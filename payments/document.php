<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined( 'MYPAYMENT' ) or die( 'Restricted access' );

class document {

    public $xpath;

    public function __construct($text) {
        $doc = new DOMDocument();
        $doc->loadXML($text);

        $this->xpath = new DOMXPath($doc);
    }

    public function getAttributes($pattern) {
        $node = $this->xpath->query($pattern)->item(0);

        $attribs = array();
        foreach ($node->attributes as $attr) {
            $attribs[$attr->name] = $attr->value;
        }

        return $attribs;
    }

}
