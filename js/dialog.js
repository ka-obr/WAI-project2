$(document).ready(function()
{
        $("#cookieDialog").dialog({
            autoOpen: true,
            modal: true,
            buttons:
            {
                "Akceptuję": function()
                {
                    $(this).dialog("close");
                }
            },
        });
});