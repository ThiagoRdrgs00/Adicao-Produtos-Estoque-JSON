<?PHP
include("conexao.php");

$json = file_get_contents('produtos.json'); //Nesse exemplo recebe o json de um arquivo que está na pasta.

$aProdutos = json_decode($json, true); //Transforma o json em um array

foreach ($aProdutos as $aProduto) { //faz um loop para cada um dos produtos do arquivo do json, e chama a função de atualização de estoque
    atualizaEstoque($aProduto["produto"], $aProduto["cor"], $aProduto["tamanho"], $aProduto["deposito"], $aProduto["data_disponibilidade"], $aProduto["quantidade"], $conexao);
}

echo "Estoque atualizado com sucesso!";

//--------------------------------------------------------- Métodos ------------------------------------------------------------------

function atualizaEstoque($sProduto, $sCor, $sTamanho, $sDeposito, $dtDataDisponibilidade, $nQuantidade, $conexao) {
    //Nessa função, ele verifica se existe um produto igual no BD;
    //Caso tenha: Ele chama a função de atualizar o produto;
    //Caso não tenha: Ele chama a função de inserir novo produto.
    $sSQL = " SELECT id " .
                " FROM estoque " .
                " WHERE estoque.produto = '$sProduto' " .
                    " AND estoque.cor = '$sCor' " .
                    " AND estoque.tamanho = '$sTamanho' " .
                    " AND estoque.deposito = '$sDeposito' " .
                    " AND estoque.data_disponibilidade = '$dtDataDisponibilidade' ";
    $rsConsulta = mysqli_query($conexao, $sSQL);
    if (mysqli_num_rows($rsConsulta) > 0) { //Verifica se tem algum registro do produto.
        $rsConsultaRows = mysqli_fetch_assoc($rsConsulta);
        atualizaProdutoEstoque($rsConsultaRows['id'], $nQuantidade, $conexao);
    } else {
        insereProdutoEstoque($sProduto, $sCor, $sTamanho, $sDeposito, $dtDataDisponibilidade, $nQuantidade, $conexao);
    }   
}

function atualizaProdutoEstoque($nId, $nQuantidade, $conexao) {
    //Nessa função, ele atualiza a quantidade do produto existente no banco mais a quantidade vinda do json.
    $sSQL = " UPDATE estoque " .
                " SET estoque.quantidade = estoque.quantidade + $nQuantidade " .
                " WHERE estoque.id = $nId ";
    $atualizarProduto = mysqli_query($conexao, $sSQL);
}

function insereProdutoEstoque($sProduto, $sCor, $sTamanho, $sDeposito, $dtDataDisponibilidade, $nQuantidade, $conexao) {
    //Nessa função, ele insere um novo produto no BD.
    $sSQL = " INSERT INTO estoque (produto, cor, tamanho, deposito, data_disponibilidade, quantidade) " .
            " VALUES ('$sProduto','$sCor','$sTamanho','$sDeposito','$dtDataDisponibilidade', $nQuantidade) ";
    $inserirProduto = mysqli_query($conexao, $sSQL);
}
?>