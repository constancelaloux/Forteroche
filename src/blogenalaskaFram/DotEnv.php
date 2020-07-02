<?php

namespace blog;
use blog\exceptions\FormatException;
use blog\exceptions\FormatExceptionContext;
use blog\exceptions\PathException;

/**
 * Description of Env
 *
 * @author constancelaloux
 */

class DotEnv
{
    const STATE_VARNAME = 0;
    const VARNAME_REGEX = '(?i:[A-Z][A-Z0-9_]*+)';
    const STATE_VALUE = 1;

    /**
     * Le chemin de .env
     */
    private $path;
    /**
     * Les données récupérées de .env
     */
    private $data;
    
    private $cursor;
    private $lineno;
    private $values;
    private $end;
    private $usePutenv = true;
    
    /**
     * @var bool If `putenv()` should be used to define environment variables or not.
     * Beware that `putenv()` is not thread safe, that's why this setting defaults to false
     */
    public function __construct(bool $usePutenv = false)
    {
        $this->usePutenv = $usePutenv;
    }
  
    public function load(string $path)
    {
        /**
         * Si le fichier n'est pas lisible ou si il n'existe pas, et si ce n'est pas un directory
         */
        if (!is_readable($path) || is_dir($path)) 
        {
            /**
             * Alors je lance une exception
             */
            throw new PathException($path);
        }
        
        /**
         * file_get_contents : Dans le cas contraire je récupére les données provenant du fichier Et ensuite 
         * j'envoi les données parsées a la fonction populate qui va définir les valeurs en tant que variables 
         * d'environnement (via putenv, $_ENV, and $_SERVER)
         */
        $this->populate($this->parse(file_get_contents($path), $path));
    }
    
    public function parse(string $data, string $path = '.env'): array
    {
        /**
         * Le chemin vers src
         */
        $this->path = $path;
        /**
         * Les données de src
         */
        $this->data = $data;
        
        $this->lineno = 1;
        $this->cursor = 0;
        
        /**
         * retourne la taille d'une chaine
         */
        $this->end = \strlen($this->data);
        
        $state = self::STATE_VARNAME;
        $this->values = [];
        $name = '';
        $this->skipEmptyLines();
        
        while ($this->cursor < $this->end) 
        {
            switch ($state) 
            {
                case self::STATE_VARNAME:
                    $name = $this->lexVarname();
                    $state = self::STATE_VALUE;
                    break;
                case self::STATE_VALUE:
                    $this->values[$name] = $this->lexValue();
                    $state = self::STATE_VARNAME;
                    break;
            }
        }
        
        if (self::STATE_VALUE === $state) 
        {
            $this->values[$name] = '';
        }
        try 
        {
            return $this->values;
        } 
        finally 
        {
            $this->values = [];
            $this->data = null;
            $this->path = null;
        }
    }
    
    /**
     * Cette fonction va permettre de générer juste les clés sans les valeurs
     */
    public function skipEmptyLines()
    {
        if (preg_match('/(?:\s*+(?:#[^\n]*+)?+)++/A', $this->data, $match, 0, $this->cursor)) 
            {
                $this->moveCursor($match[0]);
            }
        
    }
    
    /**
     * Expliquer cette fonction
     * $text contient les noms des clés
     */
    private function moveCursor(string $text)
    {
        $this->cursor += \strlen($text);
        $this->lineno += substr_count($text, "\n");
    }
    
    private function lexVarname(): string
    {
        /**
         * var name + optional export
         */
        if (!preg_match('/(export[ \t]++)?('.self::VARNAME_REGEX.')/A', $this->data, $matches, 0, $this->cursor)) 
        {
            throw $this->createFormatException('Invalid character in variable name');
        }
        
        $this->moveCursor($matches[0]);
        
        if ($this->cursor === $this->end || "\n" === $this->data[$this->cursor] || '#' === $this->data[$this->cursor]) 
        {
            if ($matches[1]) 
            {
                throw $this->createFormatException('Unable to unset an environment variable');
            }
            throw $this->createFormatException('Missing = in the environment variable declaration');
        }
        
        if (' ' === $this->data[$this->cursor] || "\t" === $this->data[$this->cursor]) 
        {
            throw $this->createFormatException('Whitespace characters are not supported after the variable name');
        }
        
        if ('=' !== $this->data[$this->cursor]) 
        {
            throw $this->createFormatException('Missing = in the environment variable declaration');
        }
        
        ++$this->cursor;
        return $matches[2];
    }
    
    private function lexValue(): string
    {
        if (preg_match('/[ \t]*+(?:#.*)?$/Am', $this->data, $matches, 0, $this->cursor)) 
        {
            $this->moveCursor($matches[0]);
            $this->skipEmptyLines();
            return '';
        }
        
        if (' ' === $this->data[$this->cursor] || "\t" === $this->data[$this->cursor]) 
        {
            throw $this->createFormatException('Whitespace are not supported before the value');
        }
        
        $v = '';
        
        do 
        {
            if ("'" === $this->data[$this->cursor]) 
            {
                $value = '';
                ++$this->cursor;
                
                while ("\n" !== $this->data[$this->cursor]) 
                {
                    if ("'" === $this->data[$this->cursor]) 
                    {
                        break;
                    }
                    
                    $value .= $this->data[$this->cursor];
                    ++$this->cursor;
                    if ($this->cursor === $this->end) 
                    {
                        throw $this->createFormatException('Missing quote to end the value');
                    }
                }
                
                if ("\n" === $this->data[$this->cursor]) 
                {
                    throw $this->createFormatException('Missing quote to end the value');
                }
                
                ++$this->cursor;
                $v .= $value;
            } 
            elseif ('"' === $this->data[$this->cursor]) 
            {
                $value = '';
                ++$this->cursor;
                
                while ('"' !== $this->data[$this->cursor] || ('\\' === $this->data[$this->cursor - 1] && '\\' !== $this->data[$this->cursor - 2])) 
                {
                    $value .= $this->data[$this->cursor];
                    ++$this->cursor;
                    if ($this->cursor === $this->end) 
                    {
                        throw $this->createFormatException('Missing quote to end the value');
                    }
                }
                
                ++$this->cursor;
                $value = str_replace(['\\"', '\r', '\n'], ['"', "\r", "\n"], $value);
                $resolvedValue = $value;
                $resolvedValue = $this->resolveVariables($resolvedValue);
                $resolvedValue = $this->resolveCommands($resolvedValue);
                $resolvedValue = str_replace('\\\\', '\\', $resolvedValue);
                $v .= $resolvedValue;
            } 
            else 
            {
                $value = '';
                $prevChr = $this->data[$this->cursor - 1];
                while ($this->cursor < $this->end && !\in_array($this->data[$this->cursor], ["\n", '"', "'"], true) && !((' ' === $prevChr || "\t" === $prevChr) && '#' === $this->data[$this->cursor])) 
                {
                    if ('\\' === $this->data[$this->cursor] && isset($this->data[$this->cursor + 1]) && ('"' === $this->data[$this->cursor + 1] || "'" === $this->data[$this->cursor + 1])) 
                    {
                        ++$this->cursor;
                    }
                    $value .= $prevChr = $this->data[$this->cursor];
                    if ('$' === $this->data[$this->cursor] && isset($this->data[$this->cursor + 1]) && '(' === $this->data[$this->cursor + 1]) 
                    {
                        ++$this->cursor;
                        $value .= '('.$this->lexNestedExpression().')';
                    }
                    ++$this->cursor;
                }
                $value = rtrim($value);
                $resolvedValue = $value;
                $resolvedValue = $this->resolveVariables($resolvedValue);
                $resolvedValue = $this->resolveCommands($resolvedValue);
                $resolvedValue = str_replace('\\\\', '\\', $resolvedValue);
                
                if ($resolvedValue === $value && preg_match('/\s+/', $value)) 
                {
                    throw $this->createFormatException('A value containing spaces must be surrounded by quotes');
                }
                
                $v .= $resolvedValue;
                
                if ($this->cursor < $this->end && '#' === $this->data[$this->cursor]) 
                {
                    break;
                }
            }
        } 
        while ($this->cursor < $this->end && "\n" !== $this->data[$this->cursor]);
        
        $this->skipEmptyLines();
        return $v;
    }
    
    private function lexNestedExpression(): string
    {
        ++$this->cursor;
        $value = '';
        while ("\n" !== $this->data[$this->cursor] && ')' !== $this->data[$this->cursor]) {
            $value .= $this->data[$this->cursor];
            if ('(' === $this->data[$this->cursor]) {
                $value .= $this->lexNestedExpression().')';
            }
            ++$this->cursor;
            if ($this->cursor === $this->end) {
                throw $this->createFormatException('Missing closing parenthesis.');
            }
        }
        if ("\n" === $this->data[$this->cursor]) {
            throw $this->createFormatException('Missing closing parenthesis.');
        }
        return $value;
    }
    
    private function createFormatException(string $message): FormatException
    {
        return new FormatException($message, new FormatExceptionContext($this->data, $this->path, $this->lineno, $this->cursor));
    }
    
    private function resolveVariables(string $value): string
    {
        if (false === strpos($value, '$')) 
        {
            //print_r($value);
            return $value;
        }
        
        $regex = '/
            (?<!\\\\)
            (?P<backslashes>\\\\*)             # escaped with a backslash?
            \$
            (?!\()                             # no opening parenthesis
            (?P<opening_brace>\{)?             # optional brace
            (?P<name>'.self::VARNAME_REGEX.')? # var name
            (?P<default_value>:[-=][^\}]++)?   # optional default value
            (?P<closing_brace>\})?             # optional closing brace
        /x';
        $value = preg_replace_callback($regex, function ($matches) 
        {
            // odd number of backslashes means the $ character is escaped
            if (1 === \strlen($matches['backslashes']) % 2) 
            {
                return substr($matches[0], 1);
            }
            // unescaped $ not followed by variable name
            if (!isset($matches['name'])) 
            {
                return $matches[0];
            }
            
            if ('{' === $matches['opening_brace'] && !isset($matches['closing_brace'])) 
            {
                throw $this->createFormatException('Unclosed braces on variable expansion');
            }
            
            $name = $matches['name'];
            
            if (isset($this->values[$name])) 
            {
                $value = $this->values[$name];
            } 
            elseif (isset($_SERVER[$name]) && 0 !== strpos($name, 'HTTP_')) 
            {
                $value = $_SERVER[$name];
            } 
            elseif (isset($_ENV[$name])) 
            {
                $value = $_ENV[$name];
            } 
            else 
            {
                $value = (string) getenv($name);
                //print_r($value);
            }
            
            if ('' === $value && isset($matches['default_value'])) 
            {
                $unsupportedChars = strpbrk($matches['default_value'], '\'"{$');
                if (false !== $unsupportedChars) 
                {
                    throw $this->createFormatException(sprintf('Unsupported character "%s" found in the default value of variable "$%s".', $unsupportedChars[0], $name));
                }
                $value = substr($matches['default_value'], 2);
                if ('=' === $matches['default_value'][1]) 
                {
                    $this->values[$name] = $value;
                }
            }
            
            if (!$matches['opening_brace'] && isset($matches['closing_brace'])) 
            {
                $value .= '}';
            }
            
            return $matches['backslashes'].$value;
        }, $value);

        return $value;
    }
    
    //8
    private function resolveCommands(string $value): string
    {
    if (false === strpos($value, '$')) 
    {
        return $value;
    }
    
    $regex = '/
        (\\\\)?               # escaped with a backslash?
        \$
        (?<cmd>
            \(                # require opening parenthesis
            ([^()]|\g<cmd>)+  # allow any number of non-parens, or balanced parens (by nesting the <cmd> expression recursively)
            \)                # require closing paren
        )
    /x';
    return preg_replace_callback($regex, function ($matches) 
    {
        if ('\\' === $matches[1]) 
        {
            return substr($matches[0], 1);
        }
        if ('\\' === \DIRECTORY_SEPARATOR) 
        {
            throw new \LogicException('Resolving commands is not supported on Windows.');
        }
        
        if (!class_exists(Process::class)) 
        {
            throw new \LogicException('Resolving commands requires the Symfony Process component.');
        }
        
        $process = method_exists(Process::class, 'fromShellCommandline') ? Process::fromShellCommandline('echo '.$matches[0]) : new Process('echo '.$matches[0]);
        
        if (!method_exists(Process::class, 'fromShellCommandline')) 
        {
            $process->inheritEnvironmentVariables();
        }
        
        $process->setEnv($this->values);
        
        try 
        {
            $process->mustRun();
        } 
        catch (ProcessException $e) 
        {
            throw $this->createFormatException(sprintf('Issue expanding a command (%s)', $process->getErrorOutput()));
        }
        return preg_replace('/[\r\n]+$/', '', $process->getOutput());
    }, $value);
}
    
    //Cette fonction va 
    public function populate(array $values)
    {
        $updateLoadedVars = false;
        $loadedVars = array_flip(explode(',', $_SERVER['SYMFONY_DOTENV_VARS'] ?? $_ENV['SYMFONY_DOTENV_VARS'] ?? ''));

        foreach ($values as $name => $value) 
        {
            // don't check existence with getenv() because of thread safety issues
            if (!isset($loadedVars[$name]) && (isset($_ENV[$name]))) 
            {
                continue;
            }
            
            if ($this->usePutenv) 
            {
                putenv("$name=$value");
            }
            
            $_ENV[$name] = $value;
            
            if (!isset($loadedVars[$name])) 
            {
                $loadedVars[$name] = $updateLoadedVars = true;
            }
        }
        
        if ($updateLoadedVars) 
        {
            unset($loadedVars['']);
            $loadedVars = implode(',', array_keys($loadedVars));

            $_ENV['SYMFONY_DOTENV_VARS'] = $_SERVER['SYMFONY_DOTENV_VARS'] = $loadedVars;

            if ($this->usePutenv) 
            {
                putenv('SYMFONY_DOTENV_VARS='.$loadedVars);

            }
        }
        
    }
}

