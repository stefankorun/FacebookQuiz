var Answers;
Answers = {
    init: function () {
        $(function () {
            var answer_btn_html = $(".js_answer_btn");
            var question_id = $(".js_question_id").text();

            var form_html = $("<form action='#'>");
            var q_id_input = $("<input name='question_id'>");
            var a_id_input = $("<input name='answer_id'>");

            q_id_input.val(question_id);
            var a_id = $(".js_answer_btn").parent().index(answer_btn_html);
            a_id_input.val(a_id);

            answer_btn_html.click(function() {
                form_html.submit();
            });
        })
    }()
};