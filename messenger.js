/* chọn nhóm chat */
// cập nhật tin nhắn
function UpdateMessenger(){
    var http = new XMLHttpRequest();
    http.onload = function(){
        var messenger = this.responseText;
        if (messenger == 'null')
        {
            console.log(messenger);
        }
        else {
            console.log(messenger);
            var ListMessenger = document.querySelector("#list-messenger");
            var li = document.createElement("li");
            li.id = "send";
            li.innerHTML = messenger;
            ListMessenger.prepend(li);
        }
    };
    const room_id = document.querySelector("#room_id").value;
    const messenger_sending_time = document.querySelector("#list-messenger").firstElementChild.querySelector("#messenger_sending_time").value;
    console.log(messenger_sending_time);
    http.open('GET', `chat.php?RoomId=${room_id}&messenger_time=${messenger_sending_time}`);
    http.send();
    
};
document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".list-room").forEach(function(button){
        button.onclick = function(){
            var http = new XMLHttpRequest();
            const room_id = button.dataset.roomid;
            http.onload = function(){
                document.querySelector(".chat").innerHTML = this.responseText;
                document.querySelector("#room_id").value = room_id;
                // chuyển tad trong thuông tin nhóm
                document.querySelectorAll(".mandates").forEach(function(button){
                    button.onclick = function(){
                       NextTab(button);
                    }
                });
                // cập nhật tin nhắn        
                setInterval(UpdateMessenger,2000);
            }
            http.open("GET",`chat.php?room_id=${room_id}`);
            http.send();
        }
    });
});
// gửi tin nhắn
function messenger(event){
    event.preventDefault();
    var http = new XMLHttpRequest();
    http.onload = function(){
        document.querySelector(".chat").innerHTML = this.responseText;
        document.querySelector('#messenger').value = '';
        // gán sự kiện cho thông tin của câu hỏi
    };
    const messenger = document.querySelector('#messenger').value;    
    const room_id = document.querySelector('#room_id').value;
    http.open("GET", `chat.php?room_id=${room_id}&messenger=${messenger}&send=có`);
    http.send();
    return false;
};      
/* chuyển menu trong chat */
function NextTab(button) {
    var mandate = button.dataset.mandates;
    var group = document.querySelector(".group");
    var member = document.querySelector(".resulft");
    var GroupNontifi = document.querySelector("#group-nontifi");
    var GroupButton =document.querySelector("#group button");
    var MemberButton =document.querySelector("#member button");

    if (mandate == 'group')
    {
        GroupNontifi.innerHTML = "Nhóm";
        group.style.display = 'block';
        member.style.display = 'none';
        GroupButton.style.color = "rgb(247, 151, 67)";
        MemberButton.style.color = "rgb(190, 190, 190)";
    }
    else if (mandate == 'member')
    {
        GroupNontifi.innerHTML = "Thành Viên";
        group.style.display = 'none';
        member.style.display = 'block';
        MemberButton.style.color = "rgb(247, 151, 67)";
        GroupButton.style.color = "rgb(190, 190, 190)";
    }
}
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".mandates").forEach(function(button){
        button.onclick = function(){
           NextTab(button);
        }
    });
});


/* tìm kiếm nhóm chat */
function SearchRoom()
{
    var https = new XMLHttpRequest();
    https.onload = function(){
        document.querySelector(".list-rooms").innerHTML = this.responseText;
    }
    var query = document.querySelector('#search-room').value;
    https.open("GET", `chat.php?query=${query}`);
    https.send();
}
/*phần menu trong đoạn chat*/
function DisplayInformation()
{
    document.querySelector(".information-room").style.display = 'block'
}
function HiddenInformation()
{
    document.querySelector(".information-room").style.display = 'none'
}

/* hiển thị giao diện thay đổi ảnh của nhóm và đổi tên nhóm*/
var display = true;
function ImgRoom()
{
    var ChangaImg =  document.querySelector('form#change-avatar');
    
    if (display)
    {
        ChangaImg.style.display = "block";
        display = false;
    }
    else
    {
        ChangaImg.style.display = "none";
        display = true;
    }
}
function NameRoom()
{
    var ChangeName = document.querySelector(".change-name");
    if (display)
    {
        ChangeName.style.display = "block";
        display = false;
    }
    else 
    {
        ChangeName.style.display = "none";
        display = true;
    }
}