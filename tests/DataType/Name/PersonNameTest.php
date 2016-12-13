<?php

/*
 * The MIT License
 *
 * Copyright 2016 Julien Fastré <julien.fastre@champs-libres.coop>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace PHPHealth\CDA\Tests\DataType\Name;

use PHPUnit\Framework\TestCase;
use PHPHealth\CDA\DataType\Name\PersonName;

/**
 * 
 *
 * @author Julien Fastré <julien.fastre@champs-libres.coop>
 */
class PersonNameTest extends TestCase
{
    public function testPersonName()
    {
        $n = new PersonName();
        $n->addPart(PersonName::FIRST_NAME, 'Quick');
        $n->addPart(PersonName::LAST_NAME, 'Flupke');
        
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $el = $dom->createElement('el');
        $dom->appendChild($el);
        
        $n->setValueToElement($el, $dom);
        
        $expected = <<<'CDA'
<el><name><given>Quick</given><family>Flupke</family></name></el>
CDA;
        $expectedDoc = new \DOMDocument('1.0');
        $expectedDoc->loadXML($expected);
        $expectedEl = $expectedDoc
                ->getElementsByTagName('el')
                ->item(0);
        
        $this->assertEqualXMLStructure($expectedEl, $el, true);
    }
    
    public function testPersonNameSingle()
    {
        $n = new PersonName();
        $n->setString('test');
        
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $el = $dom->createElement('el');
        $dom->appendChild($el);
        
        $n->setValueToElement($el, $dom);
        
        $expected = <<<'CDA'
<el><name>test</name></el>
CDA;
        $expectedDoc = new \DOMDocument('1.0');
        $expectedDoc->loadXML($expected);
        $expectedEl = $expectedDoc
                ->getElementsByTagName('el')
                ->item(0);
        
        $this->assertEqualXMLStructure($expectedEl, $el, true);
    }
    
    /**
     * @throws \InvalidArgumentException
     */
    public function testPersonNameEmpty()
    {
        $n = new PersonName();
        $n->setString('test');
        
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $el = $dom->createElement('el');
        $dom->appendChild($el);
        
        $n->setValueToElement($el, $dom);
    }
    
}