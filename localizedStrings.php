<?php
//////////////////////////////////////////////////////////////////////
// localizedStrings.php 
//
// @usage
//
//     1. Load this file.
//
//         --------------------------------------------------
//         require_once('localizedStrings.php');
//         use noknow\lib\locale\localizedStrings;
//         --------------------------------------------------
//
//     2. Initialize Dispatcher class.
//
//         --------------------------------------------------
//         $localizedStrings = new localizedStrings\LocalizedStrings();
//         --------------------------------------------------
//
//     3. Add localized strings from json file.
//
//         --------------------------------------------------
//         // When adding localized strings for English from json file.
//         $json_en = 'en.json';
//         $localizedStrings->AddLocalizedJsonFile($localizedStrings::LC_EN, $json_en);
//         
//         // When adding localized strings for Japanese from json file.
//         $json_ja = 'ja.json';
//         $localizedStrings->AddLocalizedJsonFile($localizedStrings::LC_JA, $json_ja);
//         --------------------------------------------------
//
//         [en.json]
//         --------------------------------------------------
//         {
//             "login": "Login"
//         }
//         --------------------------------------------------
//
//         [ja.json]
//         --------------------------------------------------
//         {
//             "login": "ログイン"
//         }
//         --------------------------------------------------
//
//     4. Now, you can use it!!
//
//         4-1. Get localized strings object.
//
//             --------------------------------------------------
//             // When getting localized strings for English.
//             $stringsEn = $localizedStrings->Strings($localizedStrings::LC_EN);
//             
//             // When getting localized strings for Japanese.
//             $stringsJa = $localizedStrings->Strings($localizedStrings::LC_JA);
//             --------------------------------------------------
//
//         4-2. Get localized string from a key.
//
//             --------------------------------------------------
//             // When getting localized string for 'login' in English.
//             $localizedStrings->String($localizedStrings::LC_EN, 'login');
//             --------------------------------------------------
//
//
// MIT License
//
// Copyright (c) 2019 noknow.info
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
// INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
// PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
// HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
// OR THE USE OR OTHER DEALINGS IN THE SOFTW//ARE.
//////////////////////////////////////////////////////////////////////

namespace noknow\lib\locale\localizedStrings;

class LocalizedStrings {

    //////////////////////////////////////////////////////////////////////
    // Properties
    //////////////////////////////////////////////////////////////////////
    const LC_EN = 'en';
    const LC_JA = 'ja';
    private $version;
    private $localizedStrings = array();


    //////////////////////////////////////////////////////////////////////
    // Constructor
    //////////////////////////////////////////////////////////////////////
    public function __construct() {
        $this->version = phpversion();
    }


    //////////////////////////////////////////////////////////////////////
    // Add localized strings from json file.
    //////////////////////////////////////////////////////////////////////
    public function AddLocalizedJsonFile(string $langCode, string $filePath): void {
        $contents = file_get_contents($filePath);
        if($contents === false) {
            return;
        }
        $json = json_decode($contents);
        if(json_last_error() !== JSON_ERROR_NONE) {
            return;
        }
        $this->localizedStrings[$langCode] = $json;
    }


    //////////////////////////////////////////////////////////////////////
    // Get a localized string object.
    //////////////////////////////////////////////////////////////////////
    public function Strings(string $langCode): object {
        if(array_key_exists($langCode, $this->localizedStrings)) {
            return $this->localizedStrings[$langCode];
        } else {
            return array();
        }
    }


    //////////////////////////////////////////////////////////////////////
    // Get a localized string.
    //////////////////////////////////////////////////////////////////////
    public function String(string $langCode, string $key): string {
        if(array_key_exists($langCode, $this->localizedStrings)) {
            $s = $this->localizedStrings[$langCode]->{$key};
            if(isset($s)) {
                return $s;
            } else {
                return $key;
            }
        } else {
            return $key;
        }
    }

}

