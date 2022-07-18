function fecharModal() {
    $('.modal_bg').hide();
}

function addGroupModal() {
    var html = '<h1>Criar uma nova sala</h1>';

    html += '<input type="text" id="newGroupName" placeholder="Digite o nome da sala" />';
    html += '</br><input type="button" id="newGroupButton" value="Cadastrar"/>';

    html += '<hr/><button onclick="fecharModal()">Fechar Janela</button>';
    
    
    $('.modal_area').html(html);
    $('.modal_bg').show();

    $('#newGroupButton').on('click', function() {
        var newGroupName = $('#newGroupName').val();

        if(newGroupName != '') {
            chat.addNewGroup(newGroupName, function(json) {
                if(json.error == '0') {
                    $('.add_tab').click();
                } else {
                    alert(json.errorMsg);
                }
            });
        }
    });
}

$(function(){

    chat.chatActivity();

    $('.add_tab').on('click', function(){

        var html = '<h1>Escolha um grupo</h1>';
        html += '<div id="groupList">Carregando...</div>';
        //html += '<hr/><button onclick="addGroupModal()">Nova Sala</button>';
        html += '<hr/><button class="botao-modal" onclick="fecharModal()">Fechar Janela</button>';

        
        $('.modal_area').html(html);
        $('.modal_bg').show();
        
        chat.loadGroupList(function(json){
            var html = '';
            for(var i in json.list) {
                html += '<button id="'+json.list[i].id+'">'+json.list[i].name+'</button>';
            }
            $('#groupList').html(html);

            $('#groupList').find('button').on('click', function() {
                var cid = $(this).attr('id');
                var cnm = $(this).text();

                chat.setGroups(cid, cnm);
                $('.modal_bg').hide();
            });

        });
    });

    $('nav ul').on('click', 'li', function() { 
        var id = $(this).attr('data-id');
        chat.setActiveGroup(id);
    });


    $('#sender_input').on('keyup', function(e){
        if(e.keyCode == 13) {
            var msg = $(this).val();
            $(this).val('');

            chat.sendMessage(msg);
        }

    });

    $('.sender_tools').on('click', function(){
        var msg = $('#sender_input').val();
        $('#sender_input').val('');
        chat.sendMessage(msg);
        

    });


});