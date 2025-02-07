$(document).ready(function () {
    $("button").click(function () {
      if ($(this)[0].id === "resetBtn") {
        fnClear();
      } else {
        fnGetData();
      }
    });
  });
  
  function fnGetData() {
    let inputVal = $("#data").val().trim();
    if (inputVal) {
      if (document.getElementById("pincodeID").checked) {
        var queryURL = "https://api.postalpincode.in/pincode/" + inputVal;
      } else {
        var queryURL = "https://api.postalpincode.in/postoffice/" + inputVal;
      }
      fetch(queryURL)
        .then((response) => response.json())
        .then((data) => {
          let items = data;
          if (items[0].Status === "404" || items[0].Status === "Error") {
            alert("The requested data is not found\nEnter valid inputs.!");
            return false;
          } else {
            let resultMsg = items[0].Message;
            let postOffice = items[0].PostOffice;
            let postOfficeLen = items[0].PostOffice.length;
            let htmlContent = "";
            if (postOfficeLen > 0)
              for (let i = 0; i < postOfficeLen; i++) {
                htmlContent +=
                  "<tr><td>" +
                  (i + 1) +
                  " .</td><td>" +
                  postOffice[i].Name +
                  "</td><td>" +
                  postOffice[i].BranchType +
                  "</td><td style='text-align: center'>" +
                  postOffice[i].Region +
                  "</td><td style='text-align: center'>" +
                  postOffice[i].District +
                  "</td><td style='text-align: center'>" +
                  postOffice[i].Pincode +
                  "</td></tr>";
              }
            $("#resultMsg").text(resultMsg);
            $("#bindpostOfficeDetails").html(htmlContent);
            $("#postOfficeDetails").show();
            $("#loadingIcon").hide();
          }
        });
    } else {
      alert("Enter a value to continue");
      $("#loadingIcon").hide();
    }
  }
  
  function fnClear() {
    $("#data").val("");
    $("#bindpostOfficeDetails").html("");
    $("#postOfficeDetails").hide();
  }