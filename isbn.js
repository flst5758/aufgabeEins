/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// A $( document ).ready() block.
$(document).ready(function () {
    $("#searchForm").submit(function (event) {
        var isbn = $("#isbn").val();
        $.post("IsbnJson.php", {isbn: isbn})
                .done(function (data) {
                    var results = JSON.parse(data);
                    $("#contentarea").empty();
                    for (var result of results) { 
                        var html =
                            "<div class='textblock'><dl>" +
                            "<dt>Title</dt>" +
                            "<dd>" + result._title + "</dd>" +
                            "<dt>Author</dt>" +
                            "<dd>" + result._author + "</dd>" +
                            "<dt>Publisher</dt>" +
                            "<dd>" + result._publisher + "</dd>" +
                            "<dt>isbn</dt>" +
                            "<dd>" + result._isbn + "</dd>" +
                            "</dl></div>";
                        $("#contentarea").append(html);
                    }
                })
                .fail(function (error) {
                    alert(error);
                });


        event.preventDefault();
    });
});

