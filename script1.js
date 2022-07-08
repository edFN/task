
const file = document.querySelector("#file_in");
file.addEventListener('change',(e) =>{

    var countFiles = e.target.files.length;

    document.querySelector("#msg").innerHTML=`Кол-во элементов: ${countFiles}`;

})

const buttons = document.querySelectorAll("#popup_button");


function showButton(button){
    button.parentNode.style.display="block";
    button.style.display="inline-box";
    button.parentNode.parentNode.style.display="block";
}
function ushowButton(button){
    button.parentNode.style.display="none";
    button.style.display="inline-box";
    button.parentNode.parentNode.style.display="none";
}

buttons[0].onclick = function(){
   ushowButton(buttons[0]);
}
buttons[1].onclick = function() {
   ushowButton(buttons[1]);

}




function setCursorPosition(pos, e) {
    e.focus();
    if (e.setSelectionRange) e.setSelectionRange(pos, pos);
    else if (e.createTextRange) {
        var range = e.createTextRange();
        range.collapse(true);
        range.moveEnd("character", pos);
        range.moveStart("character", pos);
        range.select()
    }
}

function mask(e) {
    //console.log('mask',e);
    var matrix = this.placeholder,// .defaultValue
        i = 0,
        def = matrix.replace(/\D/g, ""),
        val = this.value.replace(/\D/g, "");
    def.length >= val.length && (val = def);
    matrix = matrix.replace(/[_\d]/g, function(a) {
        return val.charAt(i++) || "_"
    });
    this.value = matrix;
    i = matrix.lastIndexOf(val.substr(-1));
    i < matrix.length && matrix != this.placeholder ? i++ : i = matrix.indexOf("_");
    setCursorPosition(i, this)
}
window.addEventListener("DOMContentLoaded", function() {

    var input = document.querySelector("#tel");
    input.addEventListener("input", mask, false);
    input.focus();
    setCursorPosition(3, input);

});

const form = document.querySelector("#sendData");


form.addEventListener('submit', function (e) {

    e.preventDefault();

    const xhr = new XMLHttpRequest();
    const fd = new FormData();
    let params = document.querySelectorAll('input');
    let formData = new FormData();


    //.setRequestHeader("Content-Type", "application/json");

    for(var i=0; i < params.length-1; i++){

        if(params[i].name == "file[]") {
            for(var j =0; j < params[i].files.length;j++){
                formData.append(params[i].name, params[i].files.item(j));
            }
        }else
            formData.append(params[i].name, params[i].value);

    }

    xhr.onreadystatechange = function (){

        if(this.readyState == 4 ){

            document.body.style.cursor = 'default';

            if(this.status >= 200 && this.status < 400) {

                console.log(this.responseText);

                var json = JSON.parse(this.response);


                if(json.success == "1"){
                    console.log("success");
                    showButton(buttons[0]);
                }else{
                    console.log("no_success");
                    showButton(buttons[1]);
                }
            }
            else{
                showButton(buttons[1]);
            }
        }
        else{
            document.body.style.cursor = 'progress';
        }

    };


    xhr.open('post','/request.php')
    xhr.send(formData);

})





