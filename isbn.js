/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// A $( document ).ready() block.
$(document).ready(function () {
    $("#searchForm").submit(function (event) {
        var isbn = $("#isbn").val();
        var cleanedIsbn = cleanIsbn(isbn);
        $.post("IsbnJson.php", {isbn: cleanedIsbn})
                .done(function (data) {
                    var results = JSON.parse(data);
                    $("#contentarea").empty();
                    for (var result of results) {
                        var html =
                                `<table class="item">
                                    <tr><td>Title</td><td>${result._title}</td></tr>
                                    <tr><td>Author</td><td>${result._author}</td></tr>
                                    <tr><td>Publisher</td><td>${result._publisher}</td></tr>
                                    <tr><td>ISBN</td><td>${result._isbn}</td></tr>
                                </table>`;
                        $("#contentarea").append(html);
                    }
                })
                .fail(function (error) {
                    alert(error);
                });


        event.preventDefault();
    });
    $("#isbn").keyup(function (target) {
        var isbn = $("#isbn").val();
        if(!findIsbn(isbn)){
            $("#error").text("Dies ist keine korrekte ISBN");
        }else{
            $("#error").text("");
        }
        function findIsbn(str){
            regex = /\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i;

            if (cleanIsbn(str).search(regex)>-1) {
                return true;
            }
            return false; // No valid ISBN found
        }
    });
});
function cleanIsbn(str){
    return str.replace(/-/g, '');
    
}

