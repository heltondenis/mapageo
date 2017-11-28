
$('#ret_certo').hide();

        $('#salvar').click(function() {

            var dados = $('#cadUsuario').serialize();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'funcao/add_endereco.php',
                async: true,
                data: dados,
                success: function(response) {
                    location.reload();
                }
            });

          // Alerta e direcionamento para Página //
 		$("#ret_certo").show().text('Endereço Cadastrado com sucesso!');
 		location.reload();
        });



