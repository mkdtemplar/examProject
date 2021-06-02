
var lanHostsArray = Array();
var hostsPerLan = Array();

var subnets = [1, 2, 4, 8, 16, 32, 64, 128, 256];
var hosts = [256, 128, 64, 32, 16, 8, 4, 2, 1];
var submask = [24, 25, 26, 27, 28, 29, 30, 31, 32];

function validateForm()
{
    var secondoctet = document.forms["myform"]["second"].value;
    var thirdoctet =  document.forms["myform"]["third"].value;
    var fourthoctet =   document.forms["myform"]["fourth"].value;

    if ( isNaN(secondoctet) || isNaN(thirdoctet) || isNaN(fourthoctet) ||  secondoctet < 0 || secondoctet > 255
        || thirdoctet < 0 || thirdoctet > 255 || fourthoctet < 0 || fourthoctet > 255 ||  sumHosts() > 0 ||
        secondoctet == "" || thirdoctet == "" || fourthoctet == "")
        {
            document.getElementById("myform").reset();
            return false;
        }
    else return true;
}

function resetForm()
{
    document.getElementById("myform").reset();
}

function sumHosts()
{
    var fourthOctet = parseInt(document.getElementById("fourthoctet").value);
    var sum = 0;
    var totalAvaleableHosts = 0

    var lans = document.getElementsByName("lan[]");
    for (var i = 0; i < lans.length; i++)
    {
            sum += parseInt(lans[i].value);
    }
    totalAvaleableHosts = fourthOctet - 255;
    sum += totalAvaleableHosts;
    return sum;
}

function numLans()
{
    var input = document.getElementsByName("lan[]");

    for (var i = 0; i < input.length; i++)
    {
        if (!isNaN(parseInt(input[i].value)) && parseInt(input[i].value) > 0)
        {
            lanHostsArray[i] = parseInt(input[i].value);
        }
        else
        {
            alert("You must enter value for network: " + (i + 1) + " and number of hosts must be greater than zero");
            resetForm();
            reFresh();
        }
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

    innerTable += "<table class='table-primary table-striped caption-top'>";
    innerTable += "<thead>";
    innerTable += "<tr>";

    innerTable +=
        "<th scope='col'>Network ID</th><th scope='col'>Subnet Mask</th><th scope='col'>Number of Hosts per subnet</th>" +
        "<th scope='col'>LAN</th><th scope='col'>Number of subnets</th><th scope='col'>Range of usable IP addresses</th></tr></thead>" +
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
            "." + secondoctet + "." + thirdoctet + "." + (fourthOctet + hostsPerLan[i] - 2) + "</td>" + "</tr>";

        fourthOctet += hostsPerLan[i];
    }

    innerTable += "</tbody></table>";
    $("#innertable").append(innerTable);
    $("#myModal").modal('show');
}

function test ()
{
    if (validateForm() == true)
    {
        sumHosts (); numLans(); lanHosts(); setHosts(); getSubAndMask();
    }

    else
    {
        alert("Octets must be numbers and/or greater than zero and/or less than 255 or sum of hosts exceeds available IP address poll");
        resetForm();
    }
}

function reFresh()
{
    window.location = window.location;
    $("#calculate").load("vlsm.html");
}