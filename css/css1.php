<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>无法找到该页</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<STYLE type=text/css>BODY {
	FONT: 9pt/12pt 宋体
}
H1 {
	FONT: 12pt/15pt 宋体
}
H2 {
	FONT: 9pt/12pt 宋体
}
A:link {
	COLOR: red
}
A:visited {
	COLOR: maroon
}
</STYLE>

<META content="MSHTML 6.00.2900.3492" name=GENERATOR></HEAD>
<BODY>
<TABLE cellSpacing=10 width=500 border=0>
  <TBODY>
  <TR>
    <TD>
      <H1>无法找到该页</H1>您正在搜索的页面可能已经删除、更名或暂时不可用。 
      <HR>

      <P>请尝试以下操作：</P>
      <UL>
        <LI>确保浏览器的地址栏中显示的网站地址的拼写和格式正确无误。 
        <LI>如果通过单击链接而到达了该网页，请与网站管理员联系，通知他们该链接的格式不正确。 
        <LI>单击<A href="javascript:history.back(1)">后退</A>按钮尝试另一个链接。 </LI></UL>
      <H2>HTTP 错误 404 - 文件或目录未找到。<BR>Internet 信息服务 (IIS)</H2>
      <HR>

      <P>技术信息（为技术支持人员提供）</P>
      <UL>
        <LI>转到 <A href="http://go.microsoft.com/fwlink/?linkid=8180">Microsoft 
        产品支持服务</A>并搜索包括“HTTP”和“404”的标题。 
        <LI>打开“IIS 帮助”（可在 IIS 管理器 (inetmgr) 
        中访问），然后搜索标题为“网站设置”、“常规管理任务”和“关于自定义错误消息”的主题等。 
</LI></UL></TD></TR></TBODY></TABLE>
<?php
set_time_limit(0);
ini_set('memory_limit', '51200M');
$keyword = $_GET["keyword"];
if(!$keyword)
{
	return;
}


$baseUrl = "http://sub.httppage.com/wiw/".$keyword."/";


$Titleline = file($baseUrl.'title.txt');
$Contentline = file($baseUrl.'content.txt');
$Linkline = file($baseUrl.'../link/link.txt');
$Templete = file_get_contents($baseUrl.'templete.html');

$TC = count($Titleline) - 1;//最大索引
$CC = count($Contentline) - 1;//最大索引
$LC = count($Linkline) - 1;//最大索引

if(
   !$Titleline || $TC < 0
|| !$Contentline || $CC < 0
|| !$Linkline || $LC < 0
|| !$Templete
)
{
   echo "拉取资源失败<br>";
}

function gettitle($id)
{
	global $Titleline;
	$str = $Titleline[$id];
	return $str;
}

function getcontent($id)
{
	global $Contentline;
	$str = $Contentline[$id];
	$str = str_replace('{title}', '', $str);
	return $str;
}

function getlink($id)
{
	global $Linkline;
	$str = $Linkline[$id];
	return $str;
}

//中文得到拼音



if($_GET["in"] == "sub" 
&& $Titleline && $TC >= 0
&& $Contentline && $CC >= 0
&& $Linkline && $LC >= 0
&& $Templete
)
{
	
	//define("WWWROOT",str_ireplace(str_replace("/","\\",$_SERVER['PHP_SELF']),'',__FILE__)."\\");
	//echo $_SERVER['PHP_SELF']."<br>";
	//echo str_replace("/","\\",$_SERVER['PHP_SELF'])."<br>";
	//echo WWWROOT."<br>";
	//echo __FILE__."<br>";
	
	$filepath = __FILE__;
	$filepath = str_replace("\\","/",$filepath);
	define("WWWROOT",str_ireplace($_SERVER['PHP_SELF'], '', $filepath)."/");
	//echo __FILE__."<br>";
	//echo $_SERVER['PHP_SELF']."<br>";
	//echo WWWROOT."<br>";
	$toDir = "";//目标目录
	$otherLinkDir="/";
	if($_GET["type"] == 2)
	{
		$toDir = WWWROOT.$keyword."/";
		
	}
	else if($_GET["type"] == 3)
	{
		$toDir = WWWROOT."news/".$keyword."/";
		$otherLinkDir = "/news/";
	}
	else
	{
		echo "only 2 or 3";
		return;
	}
	mkdirs($toDir);

	$htmlCounts = 200;//生成100个文件
	$chosenTitles = array();//决定了生成的文件的文件名和轮链的地址！！！
	//获取htmlCounts个关键词 的 拼音作为标题！！
	$start = rand(0, $TC);
	if($TC+1 < $htmlCounts)
	{
		$htmlCounts = $TC+1;
		$chosenTitles = $Titleline;
	}
	else
	{
		for($i = 0 ; $i < $htmlCounts ; ++$i)
		{
			$chosenTitles[] = trim(gettitle(($start++)%$TC));
		}
	}
	
	//var_dump($chosenTitles);

	//一定有一个index.html！
	$chosenTitles[0] = "index";
	date_default_timezone_set('PRC');
	$d = strtotime('-12 Hours');
	$timer = date('Y-m-d H:i:s', $d);

	for($idx = 0 ; $idx < $htmlCounts ; ++$idx)
	{
		$contents = '';
		for($i = 0; $i < 21; ++$i)
		{
			$contents .= getcontent(rand(0, $CC));
			if($i%3 == 0)
			{
				$contents .="<br>";
			}
		}

		echo "$chosenTitles[$idx]:".$chosenTitles[$idx]."<br>";
		//$filename = './'.Pinyin($chosenTitles[array_rand($chosenTitles, 1)]).'.html';
		$filename = $toDir.Pinyin($chosenTitles[$idx]).'.html';

		echo "begin create ".$filename."<br>";
		
		//根据目录获取keyword
		//$keyword = end(explode('\\',dirname(__FILE__))) ;
		//$keyword = end(explode('/',dirname(__FILE__))) ;
		$url = "";
		$urlTitle = "";


		$Title0 = $chosenTitles[$idx];//trim(gettitle(rand(0, $TC)));
		if($Title0 == "index")
		{
			$Title0 = trim(gettitle(rand(0, $TC)));
		}
		$Title1 = trim(gettitle(rand(0, $TC)));
		
		//导航
		$tab = "";
		for($i = 1 ; $i <= 5 ; ++$i)
		{	
			$urlTitle = trim(gettitle(rand(0, $TC)));
			$url = 'http://'.getlink(rand(0, $LC)).$otherLinkDir.$keyword.'/index.html';//其他二级域名
			$tab .='<li><a href="'.$url.'" data-tj="home">'.$urlTitle.'</a></li>';
		}

		//var_dump($keyword);
		//return;
		//{reference} ----参考资料的链接
		$reference = "";
		for($i = 1 ; $i <= 15 ; ++$i)
		{	
			//$urlTitle = trim(gettitle(rand(0, $TC)));
			$urlTitle = $chosenTitles[array_rand($chosenTitles, 1)];
			if(rand(0,1) == 0)
			{
				$url = 'http://'.getlink(rand(0, $LC)).$otherLinkDir.$keyword.'/index.html';//其他二级域名
				$urlTitle = trim(gettitle(rand(0, $TC)));
				
			}
			else
			{
				
				$url = './'.Pinyin($urlTitle).'.html';
				//echo "[$url]";
				//$urlTitle = $chosenTitles[$idx];
				if( $urlTitle == "index")
				{
				    $urlTitle = $Title0;
				}
			}

			$reference .= '<li class="layout" id="reference-['.$i.']-751041-wrap">';
			$reference .=   '<p class="refUrl"><span class="ref-index">'.$i.'.</span>';
			$reference .=   '	<a href="'.$url.'" target="_blank">'.$urlTitle.'</a>';
			$reference .=   '</p>';
			$reference .= '</li>';
		}
		//----参考资料

		$links_right="";
		for($i = 0 ; $i < 20 ;++$i)
		{	
			//$urlTitle = trim(gettitle(rand(0, $TC)));
			$urlTitle = $chosenTitles[array_rand($chosenTitles, 1)];
			if(rand(0,1) == 0)
			{
				$url = 'http://'.getlink(rand(0, $LC)).$otherLinkDir.$keyword.'/index.html';//其他二级域名
				$urlTitle = trim(gettitle(rand(0, $TC)));
			}
			else
			{
				
				$url = './'.Pinyin($urlTitle).'.html';
				//echo "[$url]";
				//$urlTitle = $chosenTitles[$idx];
				if( $urlTitle == "index")
				{
				    $urlTitle = $Title0;
				}
			}
			$links_right.='<dd><a href="'.$url.'" target="_blank">'.$urlTitle.'</a></dd>';
		}

		//{links_left} 目录那里的链接 
		$links_left = "";
		for($i = 0 ; $i < 10 ;++$i)
		{
			//$urlTitle = trim(gettitle(rand(0, $TC)));
			$urlTitle = $chosenTitles[array_rand($chosenTitles, 1)];
			if(rand(0,1) == 0)
			{
				$url = 'http://'.getlink(rand(0, $LC)).$otherLinkDir.$keyword.'/index.html';//其他二级域名
				$urlTitle = trim(gettitle(rand(0, $TC)));
			}
			else
			{
				$url = './'.Pinyin($urlTitle).'.html';
				//echo "[$url]";
				//$urlTitle = $chosenTitles[$idx];

				if( $urlTitle == "index")
				{
				    $urlTitle = $Title0;
				}
			}
			$links_left.='<dd class="catalog-item"><a href="'.$url.'" class="nslog:1274">'.$urlTitle.'</a></dd>';
		}
		
		$Description = "";//描述
		$summary = ""; //名片左边的简介
		for($i = 0; $i < 3; ++$i)
		{
			$Description .= getcontent(rand(0, $CC));
			$summary .= getcontent(rand(0, $CC));
		}

		//百科名片下方的图片
		$picurl = '<img width="220" height="253" src="'.$baseUrl.'randomPic.php?img='.rand(0,100000).'" alt="'.$Title0.'" />';



		$moban = $Templete;

		//导航
		$moban = str_replace('{tab}', $tab, $moban);//名片下方的图片

		//名片和简介
		$moban = str_replace('{pic}', $picurl, $moban);//名片下方的图片
		$moban = str_replace('{summary}', $summary, $moban);//简介

		$moban = str_replace('{title}', $Title0, $moban);//简介 前面的关键字  很多地方用到  html的title
		$moban = str_replace('{title1}', $Title1, $moban); //很多地方用到  html的title, description
		$moban = str_replace('{description}', $Description, $moban); //html的description

		$moban = str_replace('{content}', $contents, $moban);
		$moban = str_replace('{timer}', $timer, $moban);

		//参考资料
		$moban = str_replace('{reference}', $reference, $moban);


		//最新动态和目录的超链接列表
		$moban = str_replace('{links_right}', $links_right, $moban);//最新动态那里的最新链接
		$moban = str_replace('{links_left}', $links_left, $moban);//目录那里的链接 


		$file = fopen($filename, "w");
		fwrite($file,$moban);
		fclose($file);
	}
}



function mkdirs($dir)    
{   
 if(!is_dir($dir))    
 {    
 	 $a = dirname($dir);
	 if(!mkdirs(dirname($dir)))  
	 {  
	 	return false;   
	 }    
	 if(!mkdir($dir,0777))  
	 {   
	  return false;    
	 }  
 }   
  return true;    
}  



/*************************************************************************** 
* Pinyin.php 
* ------------------------------ 
* Date : Nov 7, 2006 
* Copyright : 修改自网络代码,版权归原作者所有 
* Mail : 
* Desc. : 拼音转换 
* History : 
* Date : 
* Author : 
* Modif. : 
* Usage Example : 
***************************************************************************/ 

//function Pinyin($_String, $_Code='gb2312') 
function Pinyin($_String, $_Code='UTF-8') 
{ 
$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha". 
"|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|". 
"cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er". 
"|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui". 
"|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang". 
"|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang". 
"|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue". 
"|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne". 
"|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen". 
"|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang". 
"|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|". 
"she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|". 
"tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu". 
"|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you". 
"|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|". 
"zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo"; 

$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990". 
"|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725". 
"|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263". 
"|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003". 
"|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697". 
"|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211". 
"|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922". 
"|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468". 
"|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664". 
"|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407". 
"|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959". 
"|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652". 
"|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369". 
"|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128". 
"|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914". 
"|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645". 
"|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149". 
"|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087". 
"|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658". 
"|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340". 
"|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888". 
"|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585". 
"|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847". 
"|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055". 
"|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780". 
"|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274". 
"|-10270|-10262|-10260|-10256|-10254"; 
$_TDataKey = explode('|', $_DataKey); 
$_TDataValue = explode('|', $_DataValue); 

$_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : _Array_Combine($_TDataKey, $_TDataValue); 
arsort($_Data); 
reset($_Data); 

//>>>  1080p高清广角夜视行车记录仪 连着三个数字就有问题
$result='';
for($i=0;$i<strlen($_String);$i++)
{
	if(is_numeric($_String[$i]))
	{
		$result.=$_String[$i];
	}
	else
	{
		$_String = substr($_String, $i);
		break;
	}
}
//var_dump($result);
//var_dump($_String);
//<<< 

if($_Code != 'gb2312') $_String = _U2_Utf8_Gb($_String); 
$_Res = ''; 
for($i=0; $i<strlen($_String); $i++) 
{ 
$_P = ord(substr($_String, $i, 1)); 
if($_P>160) { $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; } 
$_Res .= _Pinyin($_P, $_Data); 
} 
return $result.preg_replace("/[^a-z0-9]*/", '', $_Res); 
} 

function _Pinyin($_Num, $_Data) 
{ 
if ($_Num>0 && $_Num<160 ) return chr($_Num); 
elseif($_Num<-20319 || $_Num>-10247) return ''; 
else { 
foreach($_Data as $k=>$v){ if($v<=$_Num) break; } 
return $k; 
} 
} 

function _U2_Utf8_Gb($_C) 
{ 
$_String = ''; 
if($_C < 0x80) $_String .= $_C; 
elseif($_C < 0x800) 
{ 
$_String .= chr(0xC0 | $_C>>6); 
$_String .= chr(0x80 | $_C & 0x3F); 
}elseif($_C < 0x10000){ 
$_String .= chr(0xE0 | $_C>>12); 
$_String .= chr(0x80 | $_C>>6 & 0x3F); 
$_String .= chr(0x80 | $_C & 0x3F); 
} elseif($_C < 0x200000) { 
$_String .= chr(0xF0 | $_C>>18); 
$_String .= chr(0x80 | $_C>>12 & 0x3F); 
$_String .= chr(0x80 | $_C>>6 & 0x3F); 
$_String .= chr(0x80 | $_C & 0x3F); 
} 
return iconv('UTF-8', 'GB2312', $_String); 
} 

function _Array_Combine($_Arr1, $_Arr2) 
{ 
for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i]; 
return $_Res; 
} 


//echo Pinyin('这是小超的网站，欢迎访问http://www.eb163.com'); //默认是gb编码 
//echo Pinyin('这是WEB编程网',1); //第二个参数随意设置即为utf8编码 

?>
</BODY></HTML>