/**
 * Created by ALA on 08-05-2017.
 */
var cin = document.getElementById('cin');
var btn = document.getElementById("btn");
var cinText = document.getElementById('cinText');
btn.onclick = function test() {
    if(cinText.value !="1") {
        console.log(cin.value);
        cin.className = "col-sm-2 has-error";
        //console.log(cin.value)
    }
    else {
        cin.className = "col-sm-2 ";
        var form = document.getElementById("myForm");
        form.submit(function () {
            return true;

        })
    }
}

