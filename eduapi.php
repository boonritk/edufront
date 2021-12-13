<?php 
// code by:boonrit kidngan 
// 19/10/64 13.22
// version 1.0
//--------------------------------------------
  define("os", "window");
 //define("os", "linux");
 //-------------------------------------------- 
 function getSubject(){
    #$mydir = '../'; 
    $mydir = 'subject/';
    $myfiles = array_diff(scandir($mydir), array('.', '..')); 
    #print_r($myfiles);
    return $myfiles;
  }
  //----------------------------------------
  function getNameCouse()
  {
    $cur_dir;
    if(os=='window')
      $cur_dir = explode('\\', getcwd());
    else
    $cur_dir = explode('/', getcwd());
    return $cur_dir[count($cur_dir)-1];
  }
  //----------------------------------------
  // pindex =1,2,3
  function getPath($pindex)
  {
    $cur_dir;
    if(os=='window')
      $cur_dir = explode('\\', getcwd());
    else
      $cur_dir = explode('/', getcwd());
    return $cur_dir[count($cur_dir)-$pindex];
  }
  //----------------------------------------
  function getUnitInSubject($subjectname)
  {
   
    $mydir = 'subject/'.$subjectname.'/';
    $myfiles = array_diff(scandir($mydir), array('.', '..')); 
    #print_r($myfiles);
    return $myfiles; 
  }
  function cutExtention($filename){
    $ar = explode('.',$filename); 
    $i=count($ar);
    if($i==0 || $i==1)
      return $filename;
    else if($i==2)
      return $ar[0];  
    else if($i==3)
    return $ar[0].'.'.$ar[1];
    else if($i==4)
      return $ar[0].'.'.$ar[1].'.'.$ar[2];
    else
    return $filename;
  }
  function getAboutFile()
  {
     $namec=getNameCouse();
     return "../".$namec."/about/about.html";
  }

  function getArrayAboutFileTxt()
  {
     $namec=getNameCouse();
     //return "../".$namec."/about/about.html";
     $filename='about/about.txt';
     $fp = fopen($filename, "r");
     $content = fread($fp, filesize($filename));
     $lines = explode("\n", $content); 
     fclose($fp);
     //id:name:user:passw:detali
     return $lines;
    
  }
  //-------------------------------------------------------------------------------------
  // user file  Tool Function
  //-------------------------------------------------------------------------------------
  function addLearner($id,$name,$username,$pass,$detail)
  {
    $myfile = fopen("learner.dat", "a") or die("Unable to open file!");
    $txt = $id.":".$name.":".$username.":".$pass.":".$detail."\n";
    fwrite($myfile, $txt);
    fclose($myfile);
  }
  function getLearnerName($id){
    $filename='learner.dat';
    $fp = fopen($filename, "r");
    $content = fread($fp, filesize($filename));
    $lines = explode("\n", $content); 
    fclose($fp);
    //id:name:user:passw:detali
    foreach($lines as $data){
      $n = explode(':',$data);
      if($id==$n[0])
      {
        return $n[1];
      }
    }
    return "unknow";
  }
  
  function checkUser_getId($username,$password)
  {
    $filename='learner.dat';
    $fp = fopen($filename, "r");
    $content = fread($fp, filesize($filename));
    $lines = explode("\n", $content); 
    fclose($fp);
    //#id:name:user:passw:detali
    foreach($lines as $data){
      $n = explode(':',$data);
      if(count($n)<2)
        continue;
      if($username==$n[2] && $password==$n[3])
      {
        return $n;
      }
    }
    return ['-1','guest'];
  }
  function checkUser_id_lite($username,$password)
  {
    $filename='learner.txt';
    $fp = fopen($filename, "r");
    $content = fread($fp, filesize($filename));
    $lines = explode("\n", $content); 
    fclose($fp);
    foreach($lines as $data){
      $n = explode(':',$data);
      if($username==$n[1])
      {
        return $n[0];
      }
    }
    return '-1';
  }


  //-------------------------------------------------------------------------------------
  //  write learning to file 
  //-------------------------------------------------------------------------------------
  function wrLearnLog($data)
  {
    $myfile = fopen("learnlog.dat", "a") or die("Unable to open file!");
    $txt = $data."\n";
    fwrite($myfile, $txt);
    fclose($myfile);

  }
  //--------------------------------------------------
  // Function list ALL Question file .txt   
  //  return '../subject/chapter/fileQuestion'
  //--------------------------------------------------
  function getScoreQuestionFromFile($filename)
  {    
        //echo $filename;
    try
      {

        $fp = fopen($filename, "r");
        if ( !$fp ) {
          return -1;
        }
        $content = fread($fp, filesize($filename));
        $lines = explode("\n", $content);
        fclose($fp);
          $score=0;
          foreach($lines as $item){
              $ar= explode(":>", $item);
              $no=intval($ar[0]); 
            if($no>0)
            {
              $s=intval($ar[2]); 
              $score=$score+$s;
            }
          }
          return $score;
        } catch ( Exception $e ) {
          return -1;
        }    
       }
  
     
     function getCountQuestion($data)
     {
        $count=0;
        foreach($data as $item){
            $ar= explode(":>", $item);
            $no=intval($ar[0]); 
            if($no>0)
                $count++; 
        }
        return $count;   
     }

  
  function getFileQuestionAll()
  {
    $c=getSubject();
    $nc=getNameCouse();
    $namecat = getPath(2);
    $a=array("");
    //array_push($a,"blue","yellow");
    //print_r($a);
    foreach($c as $items){
      //echo $items;
      //echo "<br>";
      if($items==".DS_Store")
          continue;
      $u=getUnitInSubject($items);
      foreach($u as $items1){
        //if($items1)
        //echo $items1.'<br>';
        $name = explode('.',$items1);
        if($name[count($name)-1]=='txt')
        {
          array_push($a,"../".$nc."/subject/".$items."/".$items1);
          //echo "<li class=\"list-group-item\"><a href=\"/".$namecat."/".$nc."/questionShow.php?name=../".$nc."/subject/".$items."/".$items1."\" target=\"unit_learn\" onclick='test()' >".$items1."</a></li>";    
        }
       
    }
  }
  return $a;
  }

  function checkInArray($ar,$data,$position)
  {
    
      
      
    
  }
  function getDistictAndMaxLearning($ar_all)
  {
    if(count($ar_all)<=0)
    return $ar_all;

  //$qname=$a[0];
  //$maxSort=-1;
  $a_max=array("");
  $i=0;
  while($i<count($a)){
    echo $a[$i];
    $qname=$a[$i];
    $maxScore=-1.0;
    $haveitem=false;
    foreach($a_max as $it)
    {
      $ar_q = explode(':',$it); 
      if($ar_q[0]==$qname)
      {
        $haveitem=true;
        break;
      }
    }
    if($haveitem==true)
      continue;
    foreach($a as $items){
      $ar_q = explode(':',$item);
      if($qname==$ar_q[0])
      {
        $ar_score = explode('=',$$ar_q[1]);
        if($maxScore<floatval($ar_score[1])){
          $maxScore=floatval($ar_score[1]);
        }
      }   
    }
    array_push($a_max,$qname.':score='.$score.':maxscore='.$maxscore);
    $i++;  
  }
  }
  function getLearn($id,$max)
  {
    $filename='learnlog.dat';
    $fp = fopen($filename, "r");
    $content = fread($fp, filesize($filename));
    $lines = explode("\n", $content);
    fclose($fp);
    //print_r($lines);
    $no=0;
    $num_id=0;
    $a=array("");
    foreach($lines as $data){
      $n = explode(':',$data);
      //print_r($n);
      //echo $n[0].':::'.$id.'<br>';
      if($n[0]==$id)
      { 
        //Array ( [0] => 0 [1] => ../ภาษาซีซาร์ป/subject/2.คำสั่งควบคุมการทำงานโปรแกรม/2คำถาม1.txt [2] => 1=0,2=0,3=0,4=1, [3] => score=1/5 )
        //../ภาษาซีซาร์ป/subject/2.คำสั่งควบคุมการทำงานโปรแกรม/2คำถาม1.txt
        $ar_nameq = explode('/',$n[1]);
        $filenameq=$ar_nameq[count($ar_nameq)-1];
        // 2คำถาม1.txt
        $ar_nameq = explode('.',$filenameq);
        $questionname;
        if(count($ar_nameq)>2)
          $questionname=$ar_nameq[0].'.'.$ar_nameq[1];
        else
          $questionname=$ar_nameq[0];
        //score=1/5
        $ar_score=explode('=',$n[3]);
        $s_score= explode('/',$ar_score[1]);
        $score=$s_score[0];
        $maxscore=$s_score[1];
        
        array_push($a,$n[1].':score='.$score.':maxscore='.$maxscore);
        
      }

    }
   
    //print_r($a);
        
    return $a;

  }
  function getScoreLearn($id,$nameq,$arLearn)
  {
    $score=-1;
    foreach($arLearn as $items){
      $ar_q = explode(':',$items);
      if($nameq==$ar_q[0])
      {
        $ar_s = explode('=',$ar_q[1]);
        $s=intval($ar_s[1]); 
        if($s>$score)
          $score=$s;
      }
    }
    return $score;
  }
  function processLearning($id)
  {
    
    $a=getFileQuestionAll();
    //$ar_learn=getLearn($id,true);
    $arlearn=getLearn($id,true);
    //$a=array("");
    $allcore=0;
    $allcoreLearn=0;
    $ar_result_learn=array("");;
    foreach($a as $items){
        if(strlen($items)<=3)
          continue;
        $qscore=getScoreQuestionFromFile($items); 
        $allcore=$allcore+$qscore;
        //print_r($items);
        $scorelearn=getScoreLearn($id,$items,$arlearn);
        $ar_q1 = explode('/',$items);
        $percentL=0;
        if($scorelearn>=0){
          $allcoreLearn=$allcoreLearn+$scorelearn;
          $percentL=($scorelearn/$qscore)*100;  
        }
        
        //   ../ภาษาซีซาร์ป/subject/1.ความรู้เบื้องต้นเกี่ยวกับCS/2คำถามความรู้เบื้องต้น.tx
        //echo $ar_q1[3].':'.$ar_q1[4].':>score='.$qscore.':>score learn:'.$scorelearn.':>percent:>'.number_format($percentL,2);
        //echo "<br>";
        array_push($ar_result_learn,$ar_q1[3].':>'.$ar_q1[4].':>'.$qscore.':>'.$scorelearn.':>'.number_format($percentL,2));
    }
    $percentA=($allcoreLearn/$allcore)*100;
    //echo 'percentAll:'.number_format($percentA,2);
    array_push($ar_result_learn,'Total Score:>'.$allcore.':>'.$allcoreLearn.':>'.number_format($percentA,2));
    return $ar_result_learn;
  }

  //------------------------------------------------------
  //function about process Queston
  //------------------------------------------------------
  function chekAnswerOneC($data,$no,$ans)
  {
      $begin=false;
      $sc=0;
     foreach($data as $item){
         $ar= explode(":>", $item);
         $n=intval($ar[0]);
         if($n==$no && $begin==false)
         {
           $begin=true;
           $sc=intval($ar[2]);
           //echo $item.'<br>';   
           //echo $ans.'<br>';         
         }
         else if($begin==true && $n>0)
         {
             break;
         }
         else if($begin==true)
         {
            
             if(strpos($item,"*]")>0){ // Check corect
                   
                 $ar= explode(":>", $item);
                 //echo $ar[1].'<br>';
                 if(count($ar)>0){
                     //echo '++++++++++++<br>';      
                     if(trim($ar[1])==trim($ans))
                     {
                         //echo $item.'||||||<br>';      
                         return $sc;
                     }       
             }
         }
         }

     }
     return 0;    
  }
  function checkTrueInArray($anstrue,$arAns)
  {
     $countA=count($arAns); 
     for($j=0;$j<$countA;$j++){   
         if(trim($anstrue)==trim($arAns[$j]))
         {
             $checkTrue=true; 
             //echo '||||||sadasdasd<br>';      
             return true; 
         }
     }
     return false;
  }
  function chekAnswerManyC($data,$no,$arAns)
  {
     //echo '||||||-------------------------<br>';   
     $begin=false;
     $sc=0;
     $countA=count($arAns);
     $countTrue=0;
     $checkTrueAll=false;
     $countAnsCheck=0;
    foreach($data as $item){
        $ar= explode(":>", $item);
        $n=intval($ar[0]);
        if($n==$no && $begin==false)
        {
          $begin=true;
          $sc=intval($ar[2]);
          //echo $item.'<br>';   
          //echo $ans.'<br>';         
        }
        else if($begin==true && $n>0)
        {
            break;
        }
        else if($begin==true)
        {
           
            if(strpos($item,"*]")>0){ // Check corect
                $ar= explode(":>", $item);
                //echo $ar[1].'<br>';
                if(count($ar)>0)
                {
                  $checkTrue=checkTrueInArray($ar[1],$arAns);  
                  //echo '++++++++++++<br>';      
                  if($checkTrue==false)
                   {  
                       //break;
                       return 0;
                   }
                  else
                     $countTrue++;      
                }    
            }
        }
     }
     if($countTrue==$countA)
         return $sc;
     else
         return 0;
    }
    
   
    function getScoreQuestion($data)
    {
       $score=0;
       foreach($data as $item){
           $ar= explode(":>", $item);
           $no=intval($ar[0]); 
         if($no>0)
         {
           $s=intval($ar[2]); 
           $score=$score+$s;
         }
       }
       return $score;   
    }
    
    function getNameQuestion($noq,$data)
    {
      foreach($data as $item){
          $ar= explode(":>", $item);
          $no=intval($ar[0]); 
        if($no==$noq)
        {
          return $ar[1].' '.$ar[2].' คะแนน'; 
        }
      }
      return '';   
    }

  //-------------------------------------------------------------------------------------
  ?>