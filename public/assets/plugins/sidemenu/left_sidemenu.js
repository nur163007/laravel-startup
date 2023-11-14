$(document).ready(function () {
    getSidebar();
    //
});
function getSidebar(){
    $.ajax({
        url:"get/sidebar",
        type:"GET",
        success:function(response){
            var html = '<li><h3>Main</h3></li>';

            if (response.sidebar.length > 0){
                for (let i=0;i<response.sidebar.length; i++){
                    let sidebar = response.sidebar;
                    let url = sidebar[i]['url'];
                    if (sidebar[i]['parent'] == null && sidebar[i]['url'] != null){
                        html +="<li>"+'<a class="side-menu__item" href="'+url+'"><i class="side-menu__icon '+sidebar[i]['icon']+'"></i><span class="side-menu__label">'+sidebar[i]['name']+'</span></a>'+"</li>";
                    }
                    else{
                        html +="<li class='slide'>"+'<a class="side-menu__item submenu" data-toggle="slide" href="javascript:void(0)" onclick="getSubmenu(this)"><i class="side-menu__icon '+sidebar[i]['icon']+'"></i><span class="side-menu__label">'+sidebar[i]['name']+'</span><i class="angle fa fa-angle-right"></i></a><ul class="slide-menu">';
                        for (let j=0; j<response.submenu.length; j++){
                            let submenu = response.submenu;
                            let suburl = submenu[j]['url'];
                            if (submenu[j]['parent'] == sidebar[i]['id'] && submenu[j]['url'] != null){
                                html +="<li>"+'<a href="'+suburl+'" class="slide-item">'+submenu[j]['name']+'</a>'+"</li>";
                            }
                            // $(".submenu").html(sub);
                        }
                        html += "</ul></li>";
                    }
                }
                $(".side-menu").html(html);
                // alert(html)
            }
            else {
                $(".sidebarerr").text('No data found');
            }
        },
        error:function(error){

        }
    });
}

function getSubmenu(menu) {
    menu.classList.toggle("active");
    var dropdownContent = menu.nextElementSibling;
    if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
    } else {
        dropdownContent.style.display = "block";
    }
}
// $(".side-menu__item").on('click',function () {
//     alert(234)
// })
