
var lanHostsArray = Array();
var hostsPerLan = Array();

$(document).ready(function ()
{
    $("#submit").click(function ()
    {
        var num = parseInt(document.getElementById("numberOfLAN").value);
        for (var i = 1; i <= num; i++) {
            $("#container").append(
                "<label>LAN: " + i + "</label><input type='number' placeholder='Number of hosts' name = 'lan[]'><br>");
        }
        $("#sendTo").append("<button id='senddata' type='submit'  onclick= 'sumHosts (); numLans(); lanHosts(); setHosts(); getSubAndMask()'>Calculate VLSM</button>");
    });
});

var subnets = [1, 2, 4, 8, 16, 32, 64, 128, 256];
var hosts = [256, 128, 64, 32, 16, 8, 4, 2, 1];
var submask = [24, 25, 26, 27, 28, 29, 30, 31, 32];

function validateForm()
{
    var firstoctet = parseInt(document.forms["myform"]["first"].value);
    var secondoctet = parseInt(document.forms["myform"]["second"].value);
    var thirdoctet = parseInt(document.forms["myform"]["third"].value);
    var fourthoctet = parseInt(document.forms["myform"]["fourth"].value);
    var numberOfLAN = parseInt(document.forms["myform"]["numberOfLAN"].value);

    if (isNaN(firstoctet) || isNaN(secondoctet) || isNaN(thirdoctet) || isNaN(fourthoctet) || isNaN(numberOfLAN)
        || firstoctet < 0 || firstoctet > 255 || secondoctet < 0 || secondoctet > 255
        || thirdoctet < 0 || thirdoctet > 255 || fourthoctet < 0 || fourthoctet > 255 || numberOfLAN < 0) {
        alert("Octets must be numbers and/or greather than zaro and/or less than 255");
        return false;
    }
}

function numLans()
{
    var input = document.getElementsByName("lan[]");

    for (var i = 0; i < input.length; i++) {
        lanHostsArray[i] = parseInt(input[i].value);
    }
}

function sumHosts()
{
    var sumOfHosts = 0;
    for (var i = 0; i < lanHostsArray.length; i++) {
        sumOfHosts += lanHostsArray[i];
    }

    if (sumOfHosts > 253) {
        alert("Number of total hosts exceeds IP range");
        return false;
    }
}

function lanHosts()
{
    for (var j = 0; j < lanHostsArray.length; j++) {
        if (lanHostsArray[j] <= 8) {
            lanHostsArray[j] += 2;
        }
    }
}

function setHosts()
{
    for (var i = 0; i < lanHostsArray.length; i++) {

        for (var index = 0; index < hosts.length; index++) {
            if (lanHostsArray[i] <= hosts[index] && lanHostsArray[i] >= hosts[index + 1]) {
                hostsPerLan[i] = hosts[index];
            }
        }
    }
}

function getSubAndMask()
{
    var innerTable = "";

    hostsPerLan.sort(function (a, b) {
        return a - b;
    });

    hostsPerLan.reverse();

    innerTable += "<table>" + "\n";
    innerTable += "<caption>Results of VLSM</caption>" + "\n";
    innerTable += "<thead>" + "\n";
    innerTable += "<tr>" + "\n";

    innerTable +=
        "<th>Network ID</th><th>Subnet Mask</th><th>Number of Hosts per subnet</th>" +
        "<th>LAN</th><th>Number of subnets</th><th>Range of usable IP addresses</th></tr></thead>" +
        "<tbody>";

    var firstoctet = parseInt(document.getElementById("firstoctet").value);
    var secondoctet = parseInt(document.getElementById("secondoctet").value);
    var thirdoctet = parseInt(document.getElementById("thirdoctet").value);

    var fourthOctet = parseInt(document.getElementById("fourthoctet").value);

    for (var i = 0; i < hostsPerLan.length; i++) {

        var subnetIndex = hosts.indexOf(hostsPerLan[i]);
        var subnetNo = subnets[subnetIndex];
        var subMaskNo = submask[subnetIndex];


        innerTable += "<tr>" + "<td>" + firstoctet + "." + secondoctet + "." + thirdoctet + "." + fourthOctet + "</td>" + "<td>" +
            subMaskNo + "</td>" + "<td>" + hostsPerLan[i] + "</td>" + "<td>" + "LAN: " + (i + 1) + "</td>" + "<td>" + subnetNo + "</td>";

        innerTable += "<td>" + firstoctet + "." + secondoctet + "." + thirdoctet + "." + (fourthOctet + 1) + " - " + firstoctet +
            "." + secondoctet + "." + thirdoctet + "." + (fourthOctet + hostsPerLan[i] - 2) + "</td>" + "</tr>" + "\n";

        fourthOctet += hostsPerLan[i];
    }

    innerTable += "</tbody></table>" + "\n";

    document.getElementById("innertable").innerHTML = innerTable;

    $(document).ready(function () {
        $("#reload").append("<a href='index.html'><button>Click for new calculation</button></a>")
    });
}

