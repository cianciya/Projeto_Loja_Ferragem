function BuscaDados(){
  // $.get('http://localhost/www/controller.php', function(resposta) {
    // alert(resposta);
  // });
}

function EnviaDados(texto){
  $.ajax({
    type: 'POST',
    url: 'http://localhost/www/controller.php',
    success: function(resposta) {
      // alert(resposta);
      // Tratar a resposta aqui
    },
    error: function(xhr, status, erro) {
      // alert('Erro ao obter dados:', erro);
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const addToCartButtons = document.querySelectorAll('.add-to-cart');
  addToCartButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      alert('Adicionado no carrinho com sucesso');
      //BuscaDados();
    });
  });
});