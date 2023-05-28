$(function () {
  $(".ddd").on("click", function () {
    var $button = $(this);
    var oldValue = $button
      .closest(".sp-quantity")
      .find("input.quntity-input")
      .val();

    if ($button.text() == "+") {
      var newVal = parseFloat(oldValue) + 1;
    } else {
      // Don't allow decrementing below zero
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
      } else {
        newVal = 0;
      }
    }
    $button.closest(".sp-quantity").find("input.quntity-input").val(newVal);
  });

  $("form").submit(function (event) {
    debugger;
    let grade = $("#grade :selected").val();
    let curriculum = $("#curriculum :selected").val();
    let subject = $("#subject :selected").val();
    let chapter = $("#chapter :selected").val();
    if(chapter.length == 0){
      alert("Please enter chapter");
      return false;
    }


    let post_data = {
      grade: grade,
      curriculum: curriculum,
      subject: subject,
      chapter: chapter
    };

    console.table(post_data);
    // console.log(post_data);

    form_data = JSON.stringify(post_data);
    createStudyPlanCallback(form_data);

    function createStudyPlanCallback(form_data) {
      adaptive_url_domain = "/api/v1/createstudyplan.php";
      $("#loader").html('Creating Study Plan...<img src="images/loader.gif">');
      $.ajax({
        cache: false,
        type: "POST",
        async: true,
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        url: adaptive_url_domain,
        success: function (response) {
          $("#loader").html("");
          console.log(response);

          messages = response.data;
          append_body_div(messages)
        },
        error: function (xhr, status, error) {
          console.log(status);
          console.log(error);
          alert("Opps.. Some error occured .Please try again later.");
        },
      });
    }

    event.preventDefault();
  });

  // based upon selected subject chapter will be populated
  $("#subject").change(function () {
    let subject = $("#subject :selected").val();
    let post_data = {
      "Maths": "Chapter 3 - Playing with Numbers",
      "Science": "Chapter 4 - Getting to know Plants",
    };

    let chapter = post_data[subject];
    $("#chapter").val(chapter);
  });
});

function append_body_div(message = "") {
  let arr = [
    message.lesson_plan.choices[0].message.content,
    message.worksheet.choices[0].message.content,
    message.activities.choices[0].message.content,
    message.slides.choices[0].message.content,
  ];

  var div = $("<div></div><br> ");
  div.css({
    border: "1px solid black",
    "background-color": "",
    width: "500px",
    height: "auto",
    margin: "2px",
  });
  for (var i = 0; i < arr.length; i++) {
    var newDiv = div.clone();
    // format the text in html format
    arr[i] = arr[i].replace(/\\n/g, "<br/>");
    newDiv.html(arr[i]);

    // add copy button of div whole content
    var copyBtn = $(
      "<br/><br/><button class='button'  class='btn btn-success'>Copy</button>"
    );
    copyBtn.css({
      border: "1px solid black",
      "background-color": "white",
      width: "70px",
      height: "auto",
      margin: "2px",
    });
    copyBtn.click(function () {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(this).parent().text()).select();
      document.execCommand("copy");
      // if copy button is clicked then copy button will be removed and text 'copied' will be shown
      $(this).text("Copied");

      $temp.remove();
    });
    newDiv.append(copyBtn);
    $("body").append(newDiv);
  }
}



// append_body_div(message)
