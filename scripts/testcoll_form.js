$(document).ready(function () {
  $("form").submit(function (event) {
    user_id = $("#user_id").val();
    categories = $("#catgegory_nid").val();
    categories_array = $("#catgegory_nid").val().replace(/\s/g, "").split(",");
    quiz_title = $("#quiz_title").val();
    count_of_quesiton = $("#count_of_quesiton").val();

    long_answer = $("#long_answer").val();
    matching = $("#matching").val();
    multichoice = $("#multichoice").val();
    short_answer = $("#short_answer").val();
    truefalse = $("#truefalse").val();

    question_type = [];
    if (multichoice == 1) {
      question_type.push("multichoice");
    }
    if (matching == 1) {
      question_type.push("matching");
    }
    if (truefalse == 1) {
      question_type.push("truefalse");
    }
    if (short_answer == 1) {
      question_type.push("short_answer");
    }
    if (long_answer == 1) {
      question_type.push("long_answer");
    }

    difficulty = $("#difficulty").val();
    concepts_nid = $("#concepts_nid").val().replace(/\s/g, "").split(",")

    var post_data = {
      user_id: user_id,
      quiz_title: quiz_title,
      categories: categories_array,
      concept_ids: concepts_nid,
      question_count: count_of_quesiton,
      question_type: question_type,
      difficulty_ratio: difficulty,
      create_test_coll: true
    };

    console.table(post_data);
    console.log(post_data);
    // var form_data = new FormData();
    // form_data.append("content", JSON.stringify(post_data));
    // setTimeout(function () {
    // }, 2000);

    form_data = JSON.stringify(post_data);
    createTestCollectionCallback(form_data);

    function createTestCollectionCallback(form_data) {
      $.ajax({
        cache: false,
        type: "POST",
        async: false,
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
        url: "/api/adaptive/generatequiz",
        success: function (response) {
          console.log(response);
          alert("Successful.");
        },
        error: function (xhr, status, error) {
          alert("Opps.. Some error occured .Please try again later.");
        },
      });
    }

    event.preventDefault();
  });
});
