lanHostsArray = Array();
var count = 0;
$(document).ready(function () {
    $("#submit").click(function () {
        var num = document.getElementById("numberOfLAN").value;
        for (var i = 1; i <= num; i++) {
            $("#container").append(
                "<label>LAN: " +
                i +
                "</label><input type='number' placeholder='Number of hosts' name = 'lan' ><br>"
            );
        }
        $("#sendTo").append(
            "<button id='senddata' onclick='numLans()'>Submit data</button>"
        );
    });
});

//var cidr = document.getElementById("cidr").value;
//var fourthOctet = document.getElementById("fourthoctet").value;

var subnets = [1, 2, 4, 8, 16, 32, 64, 128, 256];
var hosts = [256, 128, 64, 32, 16, 8, 4, 2, 1];
var submask = [24, 25, 26, 27, 28, 29, 30, 31, 32];

function numLans() {
    var output = "";
    var sumOfHosts = 0;
    var numlan = document.getElementsByName("lan");
    for (var i = 0; i < numlan.length; i++) {
        lanHostsArray[i] = numlan[i].value;
        sumOfHosts += lanHostsArray[i];
    }

    lanHostsArray.sort();
    lanHostsArray.reverse();

    for (var i = 0; i < lanHostsArray.length; i++) {
        output += lanHostsArray[i] + " ";
    }

    var lan1 = lanHostsArray[0];

    for (var index = 0; index < hosts.length; i++) {
        if (lan1 <= hosts[index] && lan1 >= hosts[index + 1]) {
            var numHosts = hosts[index];
        }
    }

    document.getElementById("outputData").innerHTML = output;
}
