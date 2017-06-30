# seach-keyword
关键词匹配搜索

<!DOCTYPE html>

<html>

<head>

<meta charset=" utf-8">

<meta name="author" content="http://www.softwhy.com/" />

<title>搜索框关键字智能匹配实例代码</title>

<style>

body, ul, li 
{
 margin:0;
 padding:0;
}
body 
{
 font-size:12px;
 font-family:sumsun, arial;
 background:#FFFFFF;
}
.gover_search 
{
 position:relative;
 z-index:99;
 height:63px;
 padding:15px 0 0 20px;
 border:1px solid #b8cfe6;
 border-bottom:0;
 background:url(../images/gover_search_bg.gif) repeat-x 0 0;
}
.gover_search_form {height:36px;}
.gover_search .search_t 
{
 float:left;
 width:112px;
 line-height:26px;
 color:#666;
}
.gover_search .input_search_key 
{
 float:left;
 width:462px;
 height:18px;
 padding:3px;
 margin-right:5px;
 border:1px solid #ccc;
 line-height:18px;
 background:#fff;
}
.gover_search .search_btn 
{
 float:left;
 width:68px;
 height:26px;
 overflow:hidden;
 border:1px solid #ccc;
 text-align:center;
 color:#ff3300;
 letter-spacing:5px;
 background:url(../images/gover_search_bg.gif) no-repeat 0 -79px;
 cursor:pointer;
 font-weight:bold;
}
.gover_search .search_suggest 
{
 position:absolute;
 z-index:999;
 left:132px;
 top:41px;
 width:468px;
 border:1px solid #ccc;
 border-top:none;
 display:none;
 color:#004080;
}
.gover_search .search_suggest li 
{
 height:24px;
 overflow:hidden;
 padding-left:3px;
 line-height:24px;
 background:#fff;
 cursor:default;
}
.gover_search .search_suggest li.hover {background:#ddd;}
.num_right 
{
 float:right;
 text-align:right;
 line-height:24px;
 padding-right:10px
}
</style>
</head>
<body>

<div class="gover_search">
	<div class="gover_search_form clearfix"> 
		<span class="search_t">关键词匹配搜索</span>
		<input type="text" class="input_search_key" id="gover_search_key" placeholder="请输入关键词直接搜索" />
		<div class="search_suggest" id="gov_search_suggest">
			<ul>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript" src="http://www.softwhy.com/mytest/jQuery/jquery-1.8.3.js"></script>
<script type="text/javascript"> 
function oSearchSuggest(searchFuc)
{ 
	var input = $('#gover_search_key'); 
	var suggestWrap = $('#gov_search_suggest'); 
	var key = ""; 
	var init = function(){ 
		input.bind('keyup',sendKeyWord); 
		input.bind('blur',function(){setTimeout(hideSuggest,100);}) 
	} 
	var hideSuggest = function(){ 
		suggestWrap.hide(); 
	} 
	//发送请求，根据关键字到后台查询 
	var sendKeyWord = function(event){ 
		//键盘选择下拉项 
		if(suggestWrap.css('display')=='block'&&event.keyCode == 38||event.keyCode == 40)
		{ 
			var current = suggestWrap.find('li.hover'); 
			if(event.keyCode == 38)
			{ 
				if(current.length>0)
				{ 
					var prevLi = current.removeClass('hover').prev(); 
					if(prevLi.length>0)
					{ 
						prevLi.addClass('hover'); 
						input.val(prevLi.html()); 
					} 
				}
				else
				{ 
					var last = suggestWrap.find('li:last'); 
					last.addClass('hover'); 
					input.val(last.html()); 
				} 
			}
			else if(event.keyCode == 40)
			{ 
				if(current.length>0)
				{ 
					var nextLi = current.removeClass('hover').next(); 
					if(nextLi.length>0)
					{ 
						nextLi.addClass('hover'); 
						input.val(nextLi.html()); 
					} 
				}
				else
				{ 
					var first = suggestWrap.find('li:first'); 
					first.addClass('hover'); 
					input.val(first.html()); 
				} 
			} 
			//输入字符 
		}
		else
		{ 
			var valText = $.trim(input.val()); 
			if(valText ==''||valText==key)
			{ 
				return; 
			} 
			searchFuc(valText); 
			key = valText; 
		} 
	} 
	//请求返回后，执行数据展示 
	this.dataDisplay = function(data){ 
		if(data.length<=0)
		{ 
			suggestWrap.hide(); 
			return; 
		} 
		//往搜索框下拉建议显示栏中添加条目并显示 
		var li; 
		var tmpFrag = document.createDocumentFragment(); 
		suggestWrap.find('ul').html(''); 
		for(var i=0; i<data.length; i++)
		{ 
			li = document.createElement('LI'); 
			li.innerHTML = data[i]; 
			tmpFrag.appendChild(li); 
		} 
		suggestWrap.find('ul').append(tmpFrag); 
		suggestWrap.show(); 
		//为下拉选项绑定鼠标事件 
		suggestWrap.find('li').hover(function(){ 
		suggestWrap.find('li').removeClass('hover'); 
		$(this).addClass('hover'); 
	},function(){ 
		$(this).removeClass('hover'); 
	}).bind('click',function(){ 
		$(this).find("span").remove(); 
		input.val(this.innerHTML); 
		suggestWrap.hide(); 
	}); 
} 
init(); 
}; 
//实例化输入提示的JS,参数为进行查询操作时要调用的函数名 
var searchSuggest = new oSearchSuggest(sendKeyWordToBack); 
//这是一个模似函数，实现向后台发送ajax查询请求，并返回一个查询结果数据，传递给前台的JS,再由前台JS来展示数据。本函数由程序员进行修改实现查询的请求 
//参数为一个字符串，是搜索输入框中当前的内容 
function sendKeyWordToBack(keyword){ 
 var aData = []; 
 aData.push('<span class="num_right">约100个</span>'+keyword+'返回数据1'); 
 aData.push('<span class="num_right">约200个</span>'+keyword+'返回数据2'); 
 aData.push('<span class="num_right">约100个</span>'+keyword+'返回数据3'); 
 aData.push('<span class="num_right">约50000个</span>'+keyword+'返回数据4'); 
 aData.push('<span class="num_right">约1044个</span>'+keyword+'2012是真的'); 
 aData.push('<span class="num_right">约100个</span>'+keyword+'2012是假的'); 
 aData.push('<span class="num_right">约100个</span>'+keyword+'2012是真的'); 
 aData.push('<span class="num_right">约100个</span>'+keyword+'2012是假的'); 
 //将返回的数据传递给实现搜索输入框的输入提示js类 
 searchSuggest.dataDisplay(aData); 
} 
</script>
</body>
</html>
