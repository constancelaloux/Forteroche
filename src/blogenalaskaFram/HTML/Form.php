<?php
namespace blog\HTML;
use blog\HTML\HtmlBuilder;
/**
 * Description of Form
 */
class Form 
{
        /**
     * The reserved form open attributes.
     *
     * @var array
     */
    protected $reserved = ['method', 'url', 'route', 'action', 'files'];
        /**
     * The URL generator instance.
     *
     * @var UrlGenerator
     */
    protected $url;
    
    protected $inputClass;
        /**
     * The HTML builder instance.
     *
     * @var \Collective\Html\HtmlBuilder
     */
    protected $html;
        /**
     * The types of inputs to not fill values on by default.
     *
     * @var array
     */
    protected $skipValueTypes = ['file', 'password', 'checkbox', 'radio'];

        /**
     * An array of label names we've created.
     *
     * @var array
     */
    protected $labels = [];
        /**
     * Input Type.
     *
     * @var null
     */
    protected $type = null;
    //private $arrayOfimputs = [];
    private $openForm;
    //private $input = [];
    private $text;
    private $input;
    private $password;
    private $inputhidden;
    private $date;
    private $search;
    private $textarea = [];
    private $button;
    private $closeForm;
    
    public function __construct()
    {
        $this->html = new HtmlBuilder();
    }
    /**
    * Getters
    */
    public function getFormOpen()
    {
        return $this->openForm;
    }
    
    public function getImput()
    {
        return $this->input;
    }

    public function getImputText()
    {
        return $this->text;
    }
    
    public function getImputPassword()
    {
        return $this->password;
    }
    
    public function getImputHidden()
    {
        return $this->inputhidden;
    }  
    
    public function getImputSearch()
    {
        return $this->search;
    } 
    
    public function getImputDate()
    {
        return $this->date;
    }  
    
    public function getTextarea()
    {
        return $this->textarea;
    }
    
    public function getButton()
    {
        return $this->button;
    }
    
    public function getFormClose()
    {
        return $this->closeForm;
    }
    
    /**
    * Setters
    */
        /**
     * The children of the form builder.
     *
     * @var FormBuilderInterface[]
     */
    private $children = [];
    /**
     * The data of children who haven't been converted to form builders yet.
     *
     * @var array
     */
    private $unresolvedChildren = [];
    
    protected $locked = false;
    
        /**
     * {@inheritdoc}
     */
    public function add($child, string $type = null, array $options = [])
    {
        print_r($child);
        print_r($type);
        print_r($options);
        if ($this->locked) {
        print_r("je suis la");
            throw new BadMethodCallException('FormBuilder methods cannot be accessed anymore once the builder is turned into a FormConfigInterface instance.');
        }
        if ($child instanceof FormBuilderInterface) {
            $this->children[$child->getName()] = $child;
            // In case an unresolved child with the same name exists
            unset($this->unresolvedChildren[$child->getName()]);
            return $this;
        }
        if (!\is_string($child) && !\is_int($child)) {
            throw new UnexpectedTypeException($child, 'string or Symfony\Component\Form\FormBuilderInterface');
        }
        if (null !== $type && !\is_string($type)) {
            throw new UnexpectedTypeException($type, 'string or null');
        }
        // Add to "children" to maintain order
        $this->children[$child] = null;
        $this->unresolvedChildren[$child] = [$type, $options];
        return $this;
    }
    //Je cree un formulaire
    
        /**
     * Open up a new HTML form.
     *
     * @param  array $options
     *
     * @return HtmlString
     */
    public function open(array $options = [])
    {
        //print_r($options);
        $method = Arr::get($options, 'method', 'post');
        //print_r($method);
        // We need to extract the proper method from the attributes. If the method is
        // something other than GET or POST we'll use POST since we will spoof the
        // actual method since forms don't support the reserved methods in HTML.
        $attributes['method'] = $this->getMethod($method);
        //print_r($attributes['method']);
        //print_r($options);
        $attributes['action'] = $this->getAction($options);
        //print_r($attributes['action']);
        $attributes['accept-charset'] = 'UTF-8';
        // If the method is PUT, PATCH or DELETE we will need to add a spoofer hidden
        // field that will instruct the Symfony request to pretend the method is a
        // different method than it actually is, for convenience from the forms.
        /*$append = $this->getAppendage($method);
        if (isset($options['files']) && $options['files']) {
            $options['enctype'] = 'multipart/form-data';
        }*/
        // Finally we're ready to create the final form HTML field. We will attribute
        // format the array of attributes. We will also add on the appendage which
        // is used to spoof requests for this PUT, PATCH, etc. methods on forms.
        $attributes = array_merge(
          $attributes, Arr::except($options, $this->reserved)
        );
        // Finally, we will concatenate all of the attributes into a single string so
        // we can build out the final form open statement. We'll also append on an
        // extra value for the hidden _method field if it's needed for the form.
        $attributes = $this->html->attributes($attributes);
        print_r($attributes);
        return $this->openForm = $this->toHtmlString('<form' . $attributes . '>');
    }
    
        /**
     * Parse the form action method.
     *
     * @param  string $method
     *
     * @return string
     */
    protected function getMethod($method)
    {
        $method = strtoupper($method);
        return $method !== 'GET' ? 'POST' : $method;
    }
    
        /**
     * Get the form action from the options.
     *
     * @param  array $options
     *
     * @return string
     */
    protected function getAction(array $options)
    {
        // We will also check for a "route" or "action" parameter on the array so that
        // developers can easily specify a route or controller action when creating
        // a form providing a convenient interface for creating the form actions.
        /*if (isset($options['url'])) 
        {
            print_r("la");
            return $this->getUrlAction($options['url']);
        }
        if (isset($options['route'])) 
        {
            print_r("la");
            return $this->getRouteAction($options['route']);
        }*/
        // If an action is available, we are attempting to open a form to a controller
        // action route. So, we will use the URL generator to get the path to these
        // actions and return them from the method. Otherwise, we'll use current.
        if (isset($options['action'])) 
        {
            return $options['action'];
        }
        //return $this->url->current();
    }
    
    
    /**
     * Create a text input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return HtmlString
     */
    public function text($name, $options = [])
    {
        return $this->text = $this->input('text', $name, $options);
    }
    
        /**
     * Create a password input field.
     *
     * @param  string $name
     * @param  array  $options
     *
     * @return HtmlString
     */
    public function password($name, $options = [])
    {
        return $this->password = $this->input('password', $name, '', $options);
    }
    
        /**
     * Create a hidden input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return HtmlString
     */
    public function hidden($name, $options = [])
    {
        return $this->inputhidden =$this->input('hidden', $name, $options);
    }
    
        /**
     * Create a search input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return HtmlString
     */
    public function search($name, $options = [])
    {
        return $this->search = $this->input('search', $name, $options);
    }
    
        /**
     * Create a datetime-local input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return HtmlString
     */
    public function date($name, $options = [])
    {
        return $this->date = $this->input('date', $name, $options);
    }
    
        /**
     * Create a form input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return HtmlString
     */
    public function input($type, $name, $options = [])
    {
        $class = 'form-control';
        
        $this->type = $type;
        //print_r($this->type);
        if (! isset($options['name'])) 
        {
            $options['name'] = $name;
            //print_r($options['name']);
        }
        // We will get the appropriate value for the given field. We will look for the
        // value in the session for the value in the old input data then we'll look
        // in the model instance if one is set. Otherwise we will just use empty.
        $id = $this->getIdAttribute($name, $options);
        //print_r($id);
        
        /*if (! in_array($type, $this->skipValueTypes)) 
        {
            $value = $this->getValueAttribute($name);
        }*/
        // Once we have the type, value, and ID we can merge them into the rest of the
        // attributes array so we can convert them into their HTML attribute format
        // when creating the HTML element. Then, we will return the entire input.
        $merge = compact('type', 'id', 'class');
        //print_r($merge);
        //die("die");
        $options = array_merge($options, $merge);
        //print_r($options);

        return $this->toHtmlString('<input' . $this->html->attributes($options) . '>');
    }
    
    /**
     * Get the ID attribute for a field name.
     *
     * @param  string $name
     * @param  array  $attributes
     *
     * @return string
     */
    public function getIdAttribute($name, $attributes)
    {
        //print_r($name);
        //print_r($attributes);
        if (array_key_exists('id', $attributes)) 
        {
            //print_r($attributes['id']);
            return $attributes['id'];
        }
        
        if (in_array($name, $this->labels)) 
        {
            //print_r($name);
            return $name;
        }
    }
    
    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     * @return \HtmlString
     */
    protected function toHtmlString($html)
    {
        //print_r(new HtmlString($html));
        return new HtmlString($html);
    }
 
    
    //Je cree un textarea
    public function setTextarea(string $type, string $key, string $label):string
    {
        //$value = $this->getValue($key);
        $inputClass = 'form-control';
        return $this->textarea = <<<HTML
            <div class="form-group">
                <label for="field{$key}">{$label}</label>
                    <textarea type="{$type}" id="field{$key}" class="{$inputClass}" name="{$key}"></textarea>
            </div>
HTML;
    }
    
    //Je cree un bouton submit
    public function setTsubmit(string $label)
    {
        $buttonClass = 'btn btn-primary';
        return $this->button =<<<HTML
            <button class="{$buttonClass}">{$label}</button>
HTML;
    }
    
    //Je cree un formulaire
    public function setFormClose()
    {
        return $this->closeForm =<<<HTML
            </form>
HTML;
    }
 }   
    //Fonction qui génére la vue avec le formulaire
    //public function createView()
    //{
        //print_r($this->data);
        /*foreach ($this->data as $key) 
        {
            //print_r($this->data);
            return $key;
        }*/
        //return array($this->data,$this->input,$this->textarea,$this->button);
        //echo $this->data;
        //echo $this->textarea;
        //echo $this->input;
        //echo $this->button;
    //}
        
    //}
    /*public function createView()
    {
        $view = '';
        
        // On génère un par un les champs du formulaire.
        foreach ($this->fields as $field)
        {
            print_r($this->fields);
            die("quand on meurt un jour c'est pour toujours");
            //$view .= $field->buildWidget().'<br />';
        }

      //return $view;*/
    /*}*/
    
    //Je recupere les valeurs
    /*private function getValue(string $key)
    {
        if(is_array($this->data))
        {
            return $this->data[$key] ?? null;
        }
        $method = 'get' .str_replace(' ', '', ucwords(str_replace('_',' ',$key)));
        return $this->data->$method();
        if($value instanceof \DateTimeInterface)
        {
            return $value->format('Y-m-d H:i:s');          
        }
        return $value;
    }
    
    public function process()
    {
        if($this->request->method() == 'POST')
        {
        $this->manager->save($this->form->entity());

        return true;
        }

        return false;
    }*/
 
     //protected $fields = [];
    //private $data;
    //private $request;
    
    /*public function __construct($data)
    {
        //$this->data = $data; 
        //$this->request = new HTTPRequest;
    }*/
 
 //use blog\HTTPRequest;

