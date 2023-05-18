$(document).ready(function() {
    // $('#codTTD').mask('00.00.00.00/0000000000');

    $('#fundo,#grupo,#num_ordem').keyup(function(){

        $('#fundo').val(("00" + $('#fundo').val()).slice(-2));
        var fundo = $('#fundo').val(),
            grupo = $('#grupo').val(),
            // secao = $('#secao').val(),
            nordem = $('#num_ordem').val();


        var acervo = fundo+"."+grupo+"/"+nordem;
        $('#localizacao').val(acervo);
    });
    $("#form-registro").on("submit",function(e){
        e.preventDefault();
        $('.response').empty();
        var form_data = new FormData(this);
        let nomeUsuario = $('#userName').text();

        form_data.append("usuario", nomeUsuario);
        $('#loading').addClass('fas fa-spinner fa-spin');
        $.ajax({
            method: 'POST',
            url: '/ArquivosCamara/insereDocumento',
            processData:false,
            contentType: false,
            data: form_data,
            success: function(data){
                if(data.trim() === 'Documento inserido no sistema com sucesso!'){
                    $(".modal-body").html(data);
                    $("#myModal").modal('show');
                    $('#form-registro').trigger("reset");
                }else{
                    $(".modal-body").html(data);
                    $("#myModal").modal('show');
                    //$('#form-registro').trigger("reset");
                }
                $('#loading').removeClass('fas fa-spinner fa-spin');
            },
            error: function(data){
                $('#loading').removeClass('fas fa-spinner fa-spin');
            }
        });
    });
});
