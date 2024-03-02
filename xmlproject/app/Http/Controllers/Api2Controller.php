<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;

class Api2Controller extends Controller
{
    //returns the timetable for a given department and year
    public function getTimetableDay(Request $request) {
        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xpath_constraint = 'timetable[@department="' . $request->input('department') . '" and @yearofstudy="' . $request->input('yearofstudy') . '"]';

        $items = $xml_obj->xpath($xpath_constraint);

        //$xpath = './timetable[' . $department . ']/week/day[' . $day . ']';

        if(!empty($items[0])) {
            return response()->json([ 'status' => 'OK', 'timetable' => $items[0] ]);
        }
        else {
            return response()->json(['status' => 'ERR', 'message' => 'no timetable available']);
        }

        //return response()->json($items);
        //return $xml_obj->xpath($xpath);
    }

    //returns the timetable for a given student (first name + last name received)
    public function getTimetableStudent(Request $request) {
        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xpath1 = 'student[firstName="' . $request->input('firstName') . '" and lastName="' . $request->input('lastName') . '"]';

        $items = $xml_obj->xpath($xpath1);

        if(!empty($items)) {
            $xpath_constraint = 'timetable[@department="' . (string)$items[0]->department . '" and @yearofstudy="' . (string)$items[0]->yearofstudy . '"]';
            $timetable = $xml_obj->xpath($xpath_constraint)[0];
        }

        if(isset($timetable)) {
            return response()->json(['status' => 'OK', 'timetable' => $timetable]);
        }
        else {
            return response()->json(['status' => 'ERR', 'message' => 'no timetable for this student for some reason']);
        }
        
    }

    //change a node for a given lecture. requires department, year, day from monday to friday, class type (lecture or lab),
    //name of the subject, which node to modify and what to modify it with, respectively
    //the change is saved into the XML file
    public function modifyNode(Request $request) {

        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xpath_search = 'timetable[@department="' . $request->input('department') . '" and @yearofstudy="' . $request->input('yearofstudy') 
                . '"]/week/day[@name="' . $request->input('dayName') .'"]/class[@type="' . $request->input('classType') . '" and 
                subjectName="' . $request->input('subjectName') . '"]';

        foreach($xml_obj->xpath($xpath_search) as $result) {
            $result->{$request->input('nodeToModify')} = $request->input('modification');
        }

        $xml_directory = Storage::disk('local')->path('file.xml');
        
        if($xml_obj->asXML($xml_directory)) {
            return response()->json(['status' => 'OK', 'message' => 'node modified successfully. you can check the XML']);
        }
        else {
            return response()->json(['status' => 'ERR', 'message' => 'issue modifying node. :(']);
        }
    }

    public function addStudent(Request $request) {
        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xml = $xml_obj->addChild('student');
        $xml->addChild('firstName', $request->input('firstName'));
        $xml->addChild('lastName', $request->input('lastName'));
        $xml->addChild('studentNumber', $request->input('studentNumber'));
        $xml->addChild('faculty', $request->input('faculty'));
        $xml->addChild('department', $request->input('department'));
        $xml->addChild('yearofstudy', $request->input('yearofstudy'));

        $xml_directory = Storage::disk('local')->path('file.xml');

        if($xml_obj->asXML($xml_directory)) {
            return response()->json(['status' => 'OK', 'message' => 'student added successfully']);
        }
        else {
            return response()->json(['status' => 'ERR', 'message' => 'issue adding student']);
        }
    }

    public function deleteStudent(Request $request) {

        $dom = new \DOMDocument;
        $file_path = Storage::disk('local')->path('file.xml');
        $dom->load($file_path);
        $xpath = new \DOMXPath($dom);

        $xpath_search = 'student[studentNumber=' . $request->input('studentNumber') . ']';

        foreach($xpath->query($xpath_search) as $record) {
            $record->parentNode->removeChild($record);
        }

        if($dom->save($file_path)) {
            return response()->json(['status' => 'OK', 'message' => 'student deleted successfully']);
        }
        else {
            return response()->json(['status' => 'ERR', 'message' => 'issue deleting student']);
        }
    }
}