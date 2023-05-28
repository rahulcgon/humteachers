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
    let classes = $("#hours").val();

    let post_data = {
      grade: grade,
      curriculum: curriculum,
      subject: subject,
      chapter: chapter,
      classes: classes,
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

          message = response.data;
          append_body_div(message);
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

  // add loader while response is not receive
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

let message = {
  lesson_plan: {
    id: "chatcmpl-7L3pc8tWrBQfp846yWtH01MsLJ7FJ",
    object: "chat.completion",
    created: 1685253972,
    model: "gpt-3.5-turbo-0301",
    usage: { prompt_tokens: 1248, completion_tokens: 332, total_tokens: 1580 },
    choices: [
      {
        message: {
          role: "assistant",
          content:
            "Grade level: 5th grade\\nDuration: 45 minutes\\nSubject: Mathematics\\n\\nLearning Objective: Students will be able to compare and order numbers up to 6 digits.\\n\\nMaterials:\\n- Whiteboard and markers\\n- Number cards\\n- Worksheets\\n- Number lines\\n\\nIntroduction (5 minutes):\\n- Teacher will review the concept of place value using the whiteboard and markers.\\n- The teacher will show a 6 digit number on the board and ask students to identify the place value of each digit.\\n\\nExploration (15 minutes):\\n- Each student will be given a set of number cards with numbers between 100,000 and 999,999.\\n- Students will work in pairs to compare and order their numbers.\\n- The teacher will circulate to monitor and assist students as needed.\\n\\nExplanation (10 minutes):\\n- Students will come back to the board and the teacher will ask them to share how they compared and ordered their numbers.\\n- The teacher will discuss different methods for comparing and ordering numbers such as using place value, number lines, and comparing digits.\\n\\nElaboration (10 minutes):\\n- Students will work on a worksheet where they will compare and order numbers up to 6 digits.\\n- The teacher will circulate and assist students as needed.\\n\\nEvaluation (5 minutes):\\n- The teacher will ask a few students to share their answers and discuss the methods they used to compare and order the numbers.\\n- The teacher will assess student understanding through observation and participation. \\n\\nClosure (5 minutes):\\n- The teacher will review the key concepts of comparing and ordering numbers up to 6 digits.\\n- The teacher will assign homework that reinforces the learning of this lesson.",
        },
        finish_reason: "stop",
        index: 0,
      },
    ],
  },
  worksheet: {
    id: "chatcmpl-7L3q2DMmS3U3b3ewlFik4bQDIsvny",
    object: "chat.completion",
    created: 1685253998,
    model: "gpt-3.5-turbo-0301",
    usage: { prompt_tokens: 1250, completion_tokens: 480, total_tokens: 1730 },
    choices: [
      {
        message: {
          role: "assistant",
          content:
            "Grade 5 Mathematics Multiple Choice Worksheet\\n\\nObjective: To test students’ knowledge and understanding of mathematical concepts taught in Grade 5.\\n\\nInstructions: Choose the best answer from the options given and write the corresponding letter in the space provided.\\n\\n1. Which of the following is a prime number?\\na) 20\\nb) 25\\nc) 31\\nd) 35\\n\\n2. What is the place value of 5 in the number 6,758?\\na) thousands\\nb) hundreds\\nc) ones\\nd) tens\\n\\n3. What is the value of 6 in the number 3,621?\\na) 6\\nb) 60\\nc) 600\\nd) 6,000\\n\\n4. What is the quotient of 42 ÷ 7?\\na) 5\\nb) 6\\nc) 7\\nd) 8\\n\\n5. Which of these is a mixed number?\\na) 3/4\\nb) 4/3\\nc) 1 1/2\\nd) 2/7\\n\\n6. What is the perimeter of a rectangle with length 7 cm and width 5 cm?\\na) 12 cm\\nb) 24 cm\\nc) 35 cm\\nd) 60 cm\\n\\n7. If a square has a side length of 8 cm, what is its area?\\na) 16 cm²\\nb) 32 cm²\\nc) 48 cm²\\nd) 64 cm²\\n\\n8. Which of these is a symmetrical shape?\\na) rectangle\\nb) parallelogram\\nc) triangle\\nd) circle\\n\\n9. Which of the following is a fraction that is equivalent to 3/5?\\na) 2/7\\nb) 3/6\\nc) 5/3\\nd) 6/10\\n\\n10. If a number is divisible by 3 and 4, which of the following is NOT a factor of that number?\\na) 2\\nb) 3\\nc) 4\\nd) 6\\n\\nAnswer Key:\\n1. c\\n2. b\\n3. d\\n4. b\\n5. c\\n6. 24 cm\\n7. d\\n8. d\\n9. b\\n10. a",
        },
        finish_reason: "stop",
        index: 0,
      },
    ],
  },
  activities: {
    id: "chatcmpl-7L3qfCyavtTcuEWBQnkiHWR204z5b",
    object: "chat.completion",
    created: 1685254037,
    model: "gpt-3.5-turbo-0301",
    usage: { prompt_tokens: 1250, completion_tokens: 297, total_tokens: 1547 },
    choices: [
      {
        message: {
          role: "assistant",
          content:
            "1. Number Sorting: The teacher can provide the students with a set of numbers and ask them to sort them in ascending or descending order. This activity will help students identify which number is greater or smaller than the others.\\n\\n2. Number Comparison: The teacher can provide the students with pairs of numbers and ask them to compare and identify which number is greater or smaller. This activity will help students practice comparing numbers and identifying the digit place values which make one number greater or smaller than the other.\\n\\n3. Number Maze: The teacher can create a maze with numbers and ask students to navigate their way through the maze by selecting the greater or smaller numbers in each step. This activity will help students develop their understanding of comparing numbers.\\n\\n4. Number Line: The teacher can create a number line and ask students to place the given numbers on the line in their appropriate place. This activity will help students visualize and understand the relative positioning of numbers.\\n\\n5. Card Sorting: The teacher can provide the students with a deck of cards with numbers on them and ask them to sort the cards in ascending or descending order. This activity will help students practice comparing and sorting numbers.\\n\\n6. Quiz or Kahoot: The teacher can create a quiz or Kahoot game with multiple-choice questions related to comparing numbers, including the use of place value and the comparison of numbers with the same and different number of digits. This activity can be done individually or in small groups and will help students assess their understanding of the topic.",
        },
        finish_reason: "stop",
        index: 0,
      },
    ],
  },
  slides: {
    id: "chatcmpl-7L3r2hAKmelUgUNozZBEb773eXt7b",
    object: "chat.completion",
    created: 1685254060,
    model: "gpt-3.5-turbo-0301",
    usage: { prompt_tokens: 1311, completion_tokens: 294, total_tokens: 1605 },
    choices: [
      {
        message: {
          role: "assistant",
          content:
            "Slide 1: Introduction\\nTitle: Knowing Our Numbers\\n\\nSlide 2: Objective\\nTitle: Objective\\nObjective: To compare and order numbers up to four digits and to create 4-digit numbers using given digits.\\n\\nSlide 3: Review\\nTitle: Review\\nContent: Ask students to recall the greatest and smallest numbers in a set of numbers. Give them additional problems to solve.\\n\\nSlide 4: Comparing Numbers\\nTitle: Comparing Numbers\\nContent: Discuss with students how to compare numbers with the same number of digits using the place value method. Provide examples for them to practice.\\n\\nSlide 5: Comparing Numbers (continued)\\nTitle: Comparing Numbers (continued)\\nContent: Discuss with students how to compare numbers with different number of digits using the place value method. Provide examples for them to practice.\\n\\nSlide 6: Creating 4-digit Numbers\\nTitle: Creating 4-digit Numbers\\nContent: Show students how to create 4-digit numbers using given digits without repeating any digit. Ask them to create as many 4-digit numbers as they can. \\n\\nSlide 7: Greatest and Smallest Numbers\\nTitle: Greatest and Smallest Numbers\\nContent: Provide a set of numbers and ask students to find the greatest and smallest numbers. Ask them to present their answers.\\n\\nSlide 8: Conclusion\\nTitle: Conclusion\\nContent: Summarize the lesson by reviewing the key concepts and asking students to present their favorite example from the lesson.",
        },
        finish_reason: "stop",
        index: 0,
      },
    ],
  },
};

// append_body_div(message)
