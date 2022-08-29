document.addEventListener("DOMContentLoaded", () => {
    console.log("Start JS");
    document.querySelectorAll(".js_article_button_deleted").forEach((element) => {
        element.addEventListener("click", (e) => fetchIdArticle(e));
    });
});

const fetchIdArticle = (e) => {
    console.log("start fetchIdArticle");
    let article_id = e.currentTarget.dataset.article_id;
    document.getElementById("js_article_deleted_id").value = article_id;
};