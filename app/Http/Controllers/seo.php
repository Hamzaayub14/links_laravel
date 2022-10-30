<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use voku\helper\HtmlDomParser;
use Illuminate\Support\Facades\Route;

use Auth;
require_once 'C:\xampp\htdocs\laravelauth\vendor\autoload.php';

class seo extends Controller
{
    //
public function dash() {
return view('dashboard');

}

public function dashs (Request $request){
    if($request->ajax()){
         $url1=$request->url;
        ini_set('max_execution_time', '600');
    $url=$url1;

    $len= strlen($url)-1;
    // include("simple_html_dom.php");
    if($url[$len]=="/"){
    $concatenated = rtrim($url, '/\\');
    }
    else{
        $concatenated=$url;
    }

$context = stream_context_create(
    array(
        'http' => array(
            'max_redirects' => 101
        )
    )
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $concatenated);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$html = curl_exec($ch);
$data = curl_exec($ch);
curl_close($ch);

    $html = HtmlDomParser::str_get_html($data);

    
    $pieces = explode("/",$concatenated);
    $ur=    $pieces[2];
    
    
    
    $pieces3 = explode(".",$ur);
    
    
     
    
    $www ='www';
    
    
    
    
    
    if (strpos($ur, $www) !== false){
            $sname = $pieces3[1];
            $com = $pieces3[2];
            $fname=$ur;
            
    }
    
    else{
            $sname = $pieces3[0];
            $com = $pieces3[1];
            $fullname=$sname.".".$com;
    }
    // echo $fullname;
    
    // // Find all links 
    $allURLs = array();
    $internalcount=0;
    $externalurls=0;
    $totalcount=0;
    
    $i=0;
    $a =[];
    $top2=[];
    $needle   = '/';
    $needle2   = '/';
    $arr=[];
    $arr2=[];
    $html2=0;
    $linksum = [];
    $intsum =[];
    $extsum = [];
    $con = 0;
    $a=$html->find('a');
//     echo $a[8]->href;
    foreach($html->find('a') as $element) 
    {
       if(!empty($element->href)){
          $first=$element->href[0];
        //  echo $element->href.'<br>'; 
    if($first==' '){
     
            $element->href = $concatenated.$element->href;
     
    }
    if($first=='/'){
    
            $element->href = $concatenated.$element->href;
         }
         elseif($first=='#'){
            $element->href = $concatenated."/".$element->href;
         }
    
    //    echo $con."\n";     
    
//     return $first;

            $totalcount++;
    
    
    
    // $element->href =str_replace('www.','',$element->href);
    // echo $element->href."\n";
    
    
    
    if (strpos($element->href, $needle) !== false) {
            $p=explode("/",$element->href);
            // echo $p[2]."\n";
    
            $needle ='.';
    
            if(strpos($p[2], $needle) !== false){
                    $q=explode(".",$p[2]);
                    // print_r($q);
            }
            // echo $q[0]."\n";
    
            if (strpos($ur, $www) !== false){
                    if($q[1] != $sname || $q[2] != $com){
                            $externalurls++;
                            // $arr[$i]=$element->href;
                            $i++;
                            // echo $sname;
                    }
                    else{
                            $arr[$i]=$element->href;
                            $i++;
                    }
                    
            }
            
            else{
                    if($q[0] != $sname || $q[1] != $com){
                            $externalurls++;
                            // $arr[$i]=$element->href;
                            $i++;
                            // echo $sname;
                    }
                    else{
                            $arr[$i]=$element->href;
                            $i++;
                    }
            }
        
            
    }
}
   
    }
   
//     return 1;
//     print_r($arr);
    
    // $arr = (array_unique($arr));
    
    // echo "T".$totalcount;
    // echo"Ex".$externalurls;
    foreach($arr as $key=>&$e){
            
        // echo $e."\n";
    
        $context = stream_context_create(
                array(
                    'http' => array(
                        'follow_location' => false
                    )
                )
            );

            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_URL, $e);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch1,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            $html1 = curl_exec($ch1);
            $data1 = curl_exec($ch1);
            curl_close($ch1);
            $contents = HtmlDomParser::str_get_html($data1);
            
            
        //     file_get_contents($e, false, $context);
        
        
        
        // $contents = file_get_contents($e);
       
        $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
        '@<head>.*?</head>@siU',            // Lose the head section
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
    );
    
     $contents = preg_replace($search, '', $contents); 
     
     $result = array_count_values(
      str_word_count(
          strip_tags($contents), 1
          )
      );
     
     $a = array_sum($result);
           
     $top2[$key] =$a.",".$e;
    }
    
    // print_r($top2);
    
    
    $ba = [];
    $int=[];
    $ext=[];
    $tot=[];
    $u=0;
    $slice = [];
    $ran2 = [];
    $ran=[];
    // function sortby($top2,$sname,$com,$concatenated,$ur,$www){
        
        $totalexternal = 0;
        $totalinternal = 0;
        $FinalTotal = 0;
        $data_temp =array();
        foreach($top2 as $item){
                // echo $item."\n";
        $data_temp[] = explode(",",$item);
        }
    
    
    $internal=0;
    $total =0;
    $external=0;
    $con=0;
    
    $needle ='.';
    
    
    $sortarray = array();
    
    $ids = array_column($data_temp, 1);
    $ids = array_unique($ids);
    $array = array_filter($data_temp, function ($key, $value) use ($ids) {
        return in_array($value, array_keys($ids));
    }, ARRAY_FILTER_USE_BOTH);
    foreach ($array as $key => $row)
    {
        $sortarray[$key] = $row[0];
    }
    
    array_multisort($sortarray, SORT_DESC, $array);
    
    // if (Auth::user()){
        
    $slice = array_slice($array,0,15);
    
    // }
    // else{
    //     $slice = array_slice($array,0,3);
    // }
    
    
    
    // print_r ($slice);
    return $slice;    
    $count1 = 0;
    $needle = "/";
    $u = 0;
    $pp = [];
    $qq = [];
    $res = [];
    foreach($slice as $key=>$links){
    
        $ran2 = $links[1];
        // HtmlDomParser::str_get_html($webcontent);
        $ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $ran2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$html2 = curl_exec($ch2);
$data2 = curl_exec($ch2);
curl_close($ch2);
        
        $ran = HtmlDomParser::str_get_html($data2);
    
        foreach($ran->find('a') as $element2) 
    {
        if(!empty($element2->href)){
        if($element2->href[0]==""){
     
            $element2->href = $concatenated.$element2->href;
     
    }
    elseif($element2->href[0]=='/'){
    
            $element2->href = $concatenated.$element2->href;
         }
         elseif($element2->href[0]=='#'){
            $element2->href = $ran2.$element2->href;
         }
    
        //  echo $element2->href."\n";
    
        $count1++;
    
        if (strpos($element2->href, $needle) !== false) {
            $pp=explode("/",$element2->href);
            // echo $pp[2]."\n";
    
            $needle ='.';
            if(!empty($pp[2])){
            if(strpos($pp[2], $needle) !== false){
                    $qq=explode(".",$pp[2]);
                    // print_r($q);
            }
        }
           
    
            if (strpos($ur, $www) !== false){
                    if($qq[1] != $sname || $qq[2] != $com){
                            $external++;
                            $arr2[$i]=$element2->href;
                            $i++;
                            // echo $sname;
                    }
                    else{
                            $arr2[$i]=$element2->href;
                            $i++;
                    }
                    
            }
            
            else{
                    if($qq[0] != $sname || $qq[1] != $com){
                            $external++;
                            $arr2[$i]=$element2->href;
                            $i++;
                            // echo $sname;
                    }
                    else{
                            $arr2[$i]=$element2->href;
                            $i++;
                    }
            }
        
            
    }
}
    
    }
        
    
     $totalinternal = $count1-$external;
    //  $external.'<br>';
//     return $arr2;
    
//     echo  $res[$u] = $links[0] / $totalinternal;
//     echo  $res[$u] = $res[$u] / $external; 
//      echo $res[$u] = $res[$u] / 10;
    
    //  print_r($res);
    
    $int[$u]=$totalinternal;
    $ext[$u]=$external;
    $tot[$u]=$count1;
    
    
    
    $external=0;
    $count1=0;
    $totalinternal=0;
    
    
    
     
         $u++;  
    
    // echo $ext[$u];
        }

    $data=[
        'slice'=>$slice,
        'int'=>$int,
        'ext'=>$ext,
        'res'=>$res
    ];

 
    
    $returnHTML = view('table')->with('slice', $slice)->render();
return response()->json(array('success' => true, 'html'=>$returnHTML));
}

   $ext=[];
return view('seotool')->with('ext',$ext);


}
}