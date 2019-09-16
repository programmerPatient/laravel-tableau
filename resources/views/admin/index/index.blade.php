<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT">
<!--[if lt IE 9]>
<script type="text/javascript" src="/admin/lib/html5shiv.js"></script>
<script type="text/javascript" src="/admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台页面</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<style>
    .navbar-logo{
        margin-left: 10px;
    }
</style>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl">
            <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/admin/index/index">
                <img src="{{$system->logo_url}}" alt="logo图片位置" style="width:100px;max-height:30px">
            </a>
            <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/admin/index/index">logo</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs" style="width:40%;letter-spacing: 8px;margin-left:30%;font-size: 20px">{{$system->web_title}}</span>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <!-- <div style="color:white;font-size:15px;">{{$system->web_title}}</div> -->
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A">{{ Auth::guard('admin') -> user()->username }} <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onClick="myselfinfo()">个人信息</a></li>
                            <li><a href="#">切换账户</a></li>
                            <li><a href="/admin/public/logout" onClick="historyClear()">退出</a></li>
                        </ul>
                    </li>
                    <li id="Hui-msg">
                    <!--     <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i>
                        </a> -->
                    </li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        @if($type == '1')
        <dl id="menu-member">
            <li><a data-href="/admin/member/index" data-title="会员列表" href="javascript:;">会员列表</a></li>
            <li><a data-href="/admin/system/update" data-title="系统设置" href="javascript:void(0)">系统设置</a></li>
        </dl>
        @endif
        @foreach($p as $val)
        <dl id="menu-article">
            <dt style="text-overflow:ellipsis;"><i class="Hui-iconfont">&#xe616;</i>{{$val['name']}}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul id="Huifold1" class="Huifold">
                    @foreach($val["project"] as $value)
                    <li class="item">
                        <h4 style="font-size:12px;font-weight:2px;text-overflow: ellipsis;display:inline-block;white-space: nowrap;width: 100%;overflow:hidden;"><i class="Hui-iconfont">&#xe681;</i>{{$value['name']}}<b>+</b></h4>
                        <div class="info">
                            <ul id="Huifold1" class="Huifold">
                                @foreach($value['views'] as $vieVule)
                                <li class="item">
                                  <a data-href="/admin/table/index?contentUrl={{$vieVule->contentUrl}}" data-title="{{$vieVule->name}}" href="javascript:;" style="text-overflow:ellipsis;display:inline-block;white-space: nowrap;width: 100%;overflow:hidden;font-size:10px">{{$vieVule->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </dd>
        </dl>
        @endforeach
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active">
                    <!-- 修改src引入地址 -->
                    <span title="我的桌面" data-href="/admin/index//admin/index/welcome">我的桌面</span>
                    <em></em></li>
        </ul>
    </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
</div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>

            <!-- 修改src引入地址 -->
            <iframe scrolling="yes" frameborder="0" src="/admin/index/welcome"></iframe>
    </div>
</div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前 </li>
        <li id="closeall">关闭全部 </li>
</ul>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>

<!-- <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script> -->
 <script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
jQuery.Huifold = function(obj,obj_c,speed,obj_type,Event){
    if(obj_type == 2){
        $(obj+":first").find("b").html("-");
        $(obj_c+":first").show()}
    $(obj).bind(Event,function(){
        if($(this).next().is(":visible")){
            if(obj_type == 2){
                return false}
            else{
                $(this).next().slideUp(speed).end().removeClass("selected");
                $(this).find("b").html("+")}
        }
        else{
            if(obj_type == 3){
                $(this).next().slideDown(speed).end().addClass("selected");
                $(this).find("b").html("-")}else{
                $(obj_c).slideUp(speed);
                $(obj).removeClass("selected");
                $(obj).find("b").html("+");
                $(this).next().slideDown(speed).end().addClass("selected");
                $(this).find("b").html("-")}
        }
    })}
$(function(){
    /*$("#min_title_list li").contextMenu('Huiadminmenu', {
        bindings: {
            'closethis': function(t) {
                console.log(t);
                if(t.find("i")){
                    t.find("i").trigger("click");
                }
            },
            'closeall': function(t) {
                alert('Trigger was '+t.id+'\nAction was Email');
            },
        }
    });*/
    $.Huifold("#Huifold1 .item h4","#Huifold1 .item .info","fast",1,"click"); /*5个参数顺序不可打乱，分别是：相应区,隐藏显示的内容,速度,类型,事件*/
});
/*个人信息*/
function myselfinfo(){
    layer.open({
        type: 1,
        area: ['300px','200px'],
        fix: false, //不固定
        maxmin: true,
        shade:0.4,
        title: '查看信息',
        content: '<div>管理员信息</div>'
    });
}

function historyClear(){
    window.history.forward(1);
}

/*资讯-添加*/
function article_add(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
/*图片-添加*/
function picture_add(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
/*产品-添加*/
function product_add(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}
/*用户-添加*/
function member_add(title,url,w,h){
    layer_show(title,url,w,h);
}

/*管理员-角色-分派权限*/
function admin_role_assign(title,url,id,w,h){
    layer_show(title,url + '?id=' + id,w,h);
}
</script>
</body>
</html>
