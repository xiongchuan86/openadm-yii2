function oa_build_left_menu(el,topmenu_id) {
    oa_topmenu_change_active(el);
    if(typeof leftMenuItems == "object"){
        if(typeof leftMenuItems[topmenu_id] == "object"){
            var currentLeftMenuItems = leftMenuItems[topmenu_id];
            var sidebar_html = '<ul class="sidebar-menu">';
            for(var i in currentLeftMenuItems){
                sidebar_html += '<li class="treeview"><a class="link" data-label="'+currentLeftMenuItems[i].content.cfg_comment+'" data-id="'+currentLeftMenuItems[i].content.id+'" href="'+currentLeftMenuItems[i].content.value.url+'"><i class="'+currentLeftMenuItems[i].content.value.icon+'"></i> <span>'+currentLeftMenuItems[i].content.cfg_comment+'</span>';
                if(currentLeftMenuItems[i].items.length == 0){
                    sidebar_html += '</a>';
                }else{
                    sidebar_html += '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span></a>'
                    var subLeftMenuItems = currentLeftMenuItems[i].items;
                    sidebar_html += '<ul class="treeview-menu">';
                    for(var j in subLeftMenuItems){
                        sidebar_html += '<li><a class="link" data-label="'+subLeftMenuItems[j].cfg_comment+'" data-id="'+subLeftMenuItems[j].id+'" href="'+subLeftMenuItems[j].value.url+'"><i class="'+ ( typeof subLeftMenuItems[j].value.icon == "undefined" ? "fa  fa-angle-right" : subLeftMenuItems[j].value.icon) +'"></i> '+subLeftMenuItems[j].cfg_comment+'</a></li>'
                    }
                    sidebar_html += '</ul>';
                }
                sidebar_html += '</li>';
            }
            sidebar_html += '</ul>';
            $('.sidebar').html(sidebar_html);
        }
    }
}

function oa_topmenu_change_active(el) {
    $(el).parent().parent().find('li').removeClass("active");
    $(el).parent().addClass("active");
}

function stopPropagation(e) {
    e = e || window.event;
    if(e.stopPropagation) { //W3C阻止冒泡方法
        e.stopPropagation();
    } else {
        e.cancelBubble = true; //IE阻止冒泡方法
    }
}

function initOpenAdmMenus() {
    var iframe_min_height = 550;
    $('.sidebar a.link').each(function(index,el){
        var id = $(el).data('id');
        var tab_box = $('#tab_box');
        var url   = $(el).attr('href');
        var label = $(el).data('label');

        var body_height    = $('body').outerHeight();
        var header_height  = $('.main-header').outerHeight();

        var footer_height  = $('.main-footer').outerHeight();

        if($(el).parent().find('.treeview-menu').length==0){
            $(el).bind('click',function (e) {
                //判断tab是否已经存在
                if($('#tab_nav_'+id).length==0) {
                    //create tab nav
                    var tab_nav = $('<li data-id="'+id+'"  id="tab_nav_'+id+'" class="active"><a href="#tab_'+id+'" data-toggle="tab">'+label+' <i class="fa fa-remove" tabclose="20000" onclick="oa_tab_close('+id+')"></i></a></li>');
                    $('#tab_nav').append(tab_nav);
                    //create content
                    var tab = $('<div class="tab-pane active" id="tab_'+id+'"></div>');
                    tab_box.append(tab);
                    var iframe = $('<iframe id="iframe_'+id+'" width="100%" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="auto" allowtransparency="yes" src="" />');
                    $('#tab_'+id).html(iframe);
                    $("#iframe_"+id).attr('src',url);
                    //添加完tab后才能获取其height
                    var tab_nav_height = $('#tab_nav').outerHeight();
                    var iframe_height  = body_height - header_height - tab_nav_height - footer_height;
                    if(iframe_height < iframe_min_height){
                        iframe_height = iframe_min_height;
                    }
                    $("#iframe_"+id).attr('height',iframe_height);
                    oa_tab_context_menu(tab_nav);
                }
                oa_setTabActiveById(id);
                return false;
            });//end click
        }
    });
}

function oa_setTabActiveById(id) {
    //切换active为当前的tab
    $('#tab_nav li').removeClass('active');
    $('#tab_nav_'+id).addClass('active');
    //tab content
    $('#tab_box div').removeClass('active');
    $('#tab_'+id).addClass('active');
}

function resizeIFramesSize() {
    var body_height    = $('body').outerHeight();
    var header_height  = $('.main-header').outerHeight();
    var footer_height  = $('.main-footer').outerHeight();
    var tab_nav_height = $('#tab_nav').outerHeight();
    var iframe_height  = body_height - header_height - tab_nav_height - footer_height;
    $("iframe").attr('height',iframe_height);
}

function oa_tab_close(id) {
    var tabnavbid = '#tab_nav_'+id;
    var tabid    = '#tab_'+id;

    var next = $(tabnavbid).next();
    var prev = $(tabnavbid).prev();
    if(next.length>0){
        oa_setTabActiveById($(next).data('id'));
    }else{
        if(prev.length>0){
            oa_setTabActiveById($(prev).data('id'));
        }
    }

    $(tabid).remove();
    $(tabnavbid).remove();
}

function oa_tab_context_menu(el) {
    var id = $(el).data('id');
    $(el).contextMenu('tabmenu',{
        bindings:{
            'refresh':function (t) {
                oa_setTabActiveById(id);
                var url = $('#iframe_'+id).attr("src")+"?t="+new Date().getTime();
                $('#iframe_'+id).attr("src",url);
                $("div#tabmenu").hide();
            },
            'cancel': function(t) {
                $("div#tabmenu").hide();
            },
            'closeSelf':function(t){
                oa_tab_close(id);
            },
            'closeAll':function(t){
                $('#tab_nav').empty();
                $('#tab_box').empty();
            },
            'closeOther':function(t){
                $('#tab_nav li').each(function(i,o){
                    var oid = $(o).data('id');
                    if(oid != id){
                        oa_tab_close(oid);
                    }
                });
            },
            'closeLeft':function(t){
                $('#tab_nav_'+id).prevAll().remove();
                $('#tab_'+id).prevAll().remove();
                oa_setTabActiveById(id);
            },
            'closeRight':function(t){
                $('#tab_nav_'+id).nextAll().remove();
                $('#tab_'+id).nextAll().remove();
                oa_setTabActiveById(id);
            }
        }
    });
}