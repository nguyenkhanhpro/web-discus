var display = true;
function create_chat(){
    var create_room = document.querySelector(".create-room");
    if (display == true)
    {
        create_room.style.display = "block";
        display = false;
    }
    else if (display == false)
    {
        create_room.style.display = "none";
        display = true;
    }
}
// xóa biến nontifications được gửi về trong url
function HiddenNontification(){
    var nontification = document.querySelector(".nontification");
    nontification.style.display = "none";
}
// thông tin nhóm chat 
// 1. thoát khỏi thông tin nhóm chat
function exit(){
    document.querySelector(".InformationRoom").style.display = "none";
}
// 2. hàm để truy vấn thông tin nhóm
function room(button){
    var room_id = button.dataset.room;
    var https = new XMLHttpRequest();
    https.onload = function(){
        document.querySelector('.InformationRoom').innerHTML = this.responseText;
        document.querySelector('.InformationRoom').style.display = 'block';
        // gán các sự kiện khi ajax dữ liệu về
        //  sự kiện để chuyển các các menu trong thông tin của nhóm
        document.querySelectorAll(".navigation").forEach(function(button){
            button.onclick = function(){
                var navigation_id = button.dataset.id;
                var navigation_id_1 = document.querySelector('#navigation_id_1');
                var navigation_id_2 = document.querySelector('#navigation_id_2');
                var navigation_id_3 = document.querySelector('#navigation_id_3');
                var member = document.querySelector(".member");
                var admin = document.querySelector(".admin");
                var JoinGroup = document.querySelector(".join_group");
                if (navigation_id == '1'){
                    navigation_id_1.style.color = "red";
                    navigation_id_2.style.color = "black";
                    navigation_id_3.style.color = "black";
                    member.style.display = "block";
                    admin.style.display = "none";
                    JoinGroup.style.display = "none";
                }
                else if (navigation_id == '2'){
                    navigation_id_1.style.color = "black";
                    navigation_id_2.style.color = "red";
                    navigation_id_3.style.color = "black";
                    member.style.display = "none";
                    admin.style.display = "block";
                    JoinGroup.style.display = "none";
                }
                else if (navigation_id == '3'){
                    navigation_id_1.style.color = "black";
                    navigation_id_2.style.color = "black";
                    navigation_id_3.style.color = "red";
                    member.style.display = "none";
                    admin.style.display = "none";
                    JoinGroup.style.display = "block";
                }
            }
        });
    }
    https.open('GET', `room.php?room_id=${room_id}`);
    https.send();
}
document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".room_id").forEach(function(button){
        button.onclick = function() {room(button)}
    });
})
// tìm kiếm nhóm chat 
document.addEventListener("DOMContentLoaded", function(){
    document.querySelector("#search-room").onkeyup = function(){
        var https = new XMLHttpRequest();
        https.onload = function(){
            document.querySelector("ul.list-room").innerHTML = this.responseText;
            // gán lại sự kiện onclick cho button có class='room_id'
            document.querySelectorAll(".room_id").forEach(function(button){
                button.onclick = function() {room(button)}
            });
        }
        var search = document.querySelector("#search-room").value;
        https.open("GET", `search_group.php?query=${search}`);
        https.send();
    }
});