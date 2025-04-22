$(document).ready(function() {
    alert("Strona załadowana");
    
    $("#welcome").delay(3000).slideUp();

    $("#toggleList").click(function() {
        $("#foodList").toggle();
    });

    $("#changeTextColor").click(function() {
        $(".do").css("color", $("#colorSelect").val());
    });

    $("#changeBgColor").click(function() {
        $(".do").css("background-color", $("#colorSelect").val());
    });

    $("#toggleStyle").click(function() {
        $("#wishes").toggleClass("style1 style2");
    });

    $("#textInput").on("change", function() {
        $("#textOutput").text($(this).val());
    });

    $("#gallery").on("click", "img", function() {
        $("#mainImage").attr("src", $(this).attr("src"));
    });

    $("#addTask").click(function() {
        $("#taskList").append(`<li>${$("#taskInput").val()}</li>`);
    });
});
