<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use File;

use App\Http\Controllers\Controller;
use App\Models\User;

class ApiController extends Controller
{
    //returns the timetable for a given department and year
    public function getTimetableDay($department, $year) {
        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xpath_constraint = 'timetable[@department="' . $department . '" and @yearofstudy="' . $year . '"]';

        $items = $xml_obj->xpath($xpath_constraint)[0];

        //$xpath = './timetable[' . $department . ']/week/day[' . $day . ']';

        return $items->asXML();

        //return response()->json($items);
        //return $xml_obj->xpath($xpath);
    }

    //returns the timetable for a given student (first name + last name received)
    public function getTimetableStudent($firstName, $lastName) {
        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xpath1 = 'student[firstName="' . $firstName . '" and lastName="' . $lastName . '"]';

        $items = $xml_obj->xpath($xpath1)[0];

        $xpath_constraint = 'timetable[@department="' . (string)$items->department . '" and @yearofstudy="' . (string)$items->yearofstudy . '"]';

        $timetable = $xml_obj->xpath($xpath_constraint)[0];

        return $timetable->asXML();
    }

    //change a node for a given lecture. requires department, year, day from monday to friday, class type (lecture or lab),
    //name of the subject, which node to modify and what to modify it with, respectively
    //the change is saved into the XML file
    public function modifyNode($department, $year, $dayName, $classType, $subjectName, $nodeToModify, $modification) {

        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xpath_search = 'timetable[@department="' . $department . '" and @yearofstudy="' . $year . '"]/week
                /day[@name="' . $dayName .'"]/class[@type="' . $classType . '" and subjectName="' . $subjectName . '"]';

        foreach($xml_obj->xpath($xpath_search) as $result) {
            $result->{$nodeToModify} = $modification;
        }

        $xml_directory = Storage::disk('local')->path('file.xml');

        return $xml_obj->asXML($xml_directory);
    }

    public function addStudent($firstName, $lastName, $studentNumber, $faculty, $department, $yearofstudy) {
        $xml_obj = app('App\Http\Controllers\XMLController')->parsing();

        $xml = $xml_obj->addChild('student');
        $xml->addChild('firstName', $firstName);
        $xml->addChild('lastName', $lastName);
        $xml->addChild('studentNumber', $studentNumber);
        $xml->addChild('faculty', $faculty);
        $xml->addChild('department', $department);
        $xml->addChild('yearofstudy', $yearofstudy);

        $xml_directory = Storage::disk('local')->path('file.xml');

        return $xml_obj->asXML($xml_directory);
    }

    public function deleteStudent($studentNumber) {

      $dom = new \DOMDocument;
      $file_path = Storage::disk('local')->path('file.xml');
      $dom->load($file_path);
      $xpath = new \DOMXPath($dom);

      $xpath_search = 'student[studentNumber=' . $studentNumber . ']';

      foreach($xpath->query($xpath_search) as $record) {
          $record->parentNode->removeChild($record);
      }

      return $dom->saveXML();
    }

}