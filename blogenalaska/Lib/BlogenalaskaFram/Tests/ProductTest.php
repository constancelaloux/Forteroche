<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MathTest
 *
 * @author constancelaloux
 */
use PHPUnit\Framework\TestCase;
class ProductTest extends TestCase

{
    //put your code here
    /*public function testDouble()
        {
            $this->assertEquals(4,\blogenalaska\Lib\BlogenalaskaFram\src\Math::double(2));
        }*/
        public function testcomputeTVAFoodProduct()
            {
                $product = new \blogenalaska\src\Product('Un produit', \blogenalaska\src\Product::FOOD_PRODUCT, 20);

                $this->assertSame(1.1, $product->computeTVA());
            }
}
