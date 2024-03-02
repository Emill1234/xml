<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use File;

use App\Http\Controllers\Controller;
use App\Models\User;

class XMLController extends Controller
{
    public function parsing() {

        //as obj using SimpleXML
        $xml_file = Storage::disk('local')->get('file.xml');

        $xml_obj = simplexml_load_string($xml_file);

        return $xml_obj;
    }

    public function parsing2() {
        //using DOM
        $xmlDoc = new \DOMDocument();
        $xml_file = Storage::disk('local')->path('file.xml');

        $xmlDoc->load($xml_file);

        return $xmlDoc;
    }

    public function validation() {
        $xml_file = Storage::disk('local')->get('file.xml');
        $xsd_path = Storage::disk('local')->path('file.xsd');
        
        // needed for getting errors
        libxml_use_internal_errors(true);

        $domDocument= new \DOMDocument();
        $domDocument->loadXML($xml_file); 
        
        if (!$domDocument->schemaValidate($xsd_path)) {
            $errors = libxml_get_errors();

            foreach ($errors as $error) {
                print_r($error);
            }

        libxml_clear_errors();
        }
        else {
            echo 'Validation successful';
        }
    }

    public function xslt() {
        $xsl = Storage::disk('local')->path('file.xsl');
        $xml = Storage::disk('local')->path('file.xml');

        $xslDoc = new \DOMDocument();
        $xslDoc->load($xsl);
     
        $xmlDoc = new \DOMDocument();
        $xmlDoc->load($xml);
     
        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xslDoc);

        return $proc->transformToXML($xmlDoc);
    }
    
}