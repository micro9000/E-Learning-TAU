$(document).on("mouseleave", ".icon-delete", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/delete.png");
});
$(document).on("mouseenter", ".icon-delete", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/delete-hover.png");
});

$(document).on("mouseleave", ".icon-edit", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/edit.png");
});
$(document).on("mouseenter", ".icon-edit", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/edit-hover.png");
});


$(document).on("mouseleave", ".icon-undo", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/undo.png");
});
$(document).on("mouseenter", ".icon-undo", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/undo-hover.png");
});

$(document).on("mouseleave", ".icon-add", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/add.png");
});
$(document).on("mouseenter", ".icon-add", function() {
    $(this).attr("src", base_url + "assets/imgs/icons/add-hover.png");
});