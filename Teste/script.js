
const add = document.getElementById('add')
var acto = document.getElementById('acto')
var formulario = document.getElementById('adicinarcampo')
const mainTable = document.getElementById('maintable')
var btn = document.getElementsByClassName('btn')
var index = 1
var dados

acto.addEventListener('change', _ => {
    mainTable.style.display = 'block'
    const xhttp = new XMLHttpRequest();
    
    xhttp.onload = ()=> {
        // const dados = 
        try {
            dados =JSON.parse(JSON.stringify( xhttp.responseText)) 
            console.log('dados aqui ' + dados) 
            console.log('dados aqui ' + dados.Acto ) 
        } catch (error) {
            console.log('Falhou a conversao' + error)
        }
    }    
    xhttp.open("GET", "carregacampos.php");
    xhttp.setRequestHeader('Content-type', 'application/json')
    xhttp.send();
   
    
    index++
    

    var labelID = document.createElement('label')
    labelID.innerHTML = 'ID Artigo'
    var inputID = document.createElement('input')
    inputID.setAttribute('name', 'acto[]')
    //inputID.setAttribute('value', dados[0])
    inputID.setAttribute('readonly', 'readonly')

    var labelArtigo = document.createElement('label')
    labelArtigo.innerHTML = 'Artigo'
    var inputArtigo = document.createElement('input')
    inputArtigo.setAttribute('name', 'acto[]')
    //inputArtigo.setAttribute('value', daods)
    inputArtigo.setAttribute('readonly', 'readonly')

    var labelPreco = document.createElement('label')
    labelPreco.innerHTML = 'Preço s/ IVA'
    var inputPreco = document.createElement('input')
    inputPreco.setAttribute('name', 'acto[]')
    inputPreco.setAttribute('readonly', 'readonly')

    var labelIva = document.createElement('label')
    labelIva.innerHTML = 'IVA'
    var inputIva = document.createElement('input')
    inputIva.setAttribute('name', 'acto[]')
    inputIva.setAttribute('readonly', 'readonly')

    var labelPrecoIVA = document.createElement('label')
    labelPrecoIVA.innerHTML = 'Preço c/ IVA'
    var inputPrecoIVA = document.createElement('input')
    inputPrecoIVA.setAttribute('name', 'acto[]')
    inputPrecoIVA.setAttribute('readonly', 'readonly')

    var br = document.createElement('br')




    var button = document.createElement('button')
    button.setAttribute('value', 'Remover')
    button.setAttribute('class', 'btn')
    button.innerHTML = "Remover"
    formulario.appendChild(labelID)
    formulario.appendChild(inputID)

    formulario.appendChild(labelArtigo)
    formulario.appendChild(inputArtigo)

    formulario.appendChild(labelPreco)
    formulario.appendChild(inputPreco)

    formulario.appendChild(labelIva)
    formulario.appendChild(inputIva)

    formulario.appendChild(labelPrecoIVA)
    formulario.appendChild(labelPrecoIVA)
    formulario.appendChild(button)

    formulario.appendChild(br)
})

for (let j = 0; j < btn.length; j++) {
    btn[j].addEventListener('click', _ => {
        event.preventDefault()
        console.log('Clicaste no botao ' + (j + 1))
    })
}


















































/* const btn = document.getElementsByClassName('btn')
const selectClasse = document.getElementById('selectclass')
const mainTable = document.getElementById('maintable')
const tableConsumiveis = document.getElementById('tableconsumibeis')
const tableFarmacos = document.getElementById('tablefarmacos')
const tableVacinas = document.getElementById('tablevacinas')
let c = 1
let f = 1
let v = 1
let row = mainTable.getElementsByTagName('tr')
const btnelements = document.getElementsByClassName('btn6')


for (let j = 0; j < btn.length; j++) {
    btn[j].addEventListener('click', _ => {
        let selectedOption = selectClasse.value
        if (selectedOption == 'CONSUMIVEIS') {
            console.log(mainTable.rows[j + 1].cells[0].innerHTML)
            console.log(mainTable.rows[j + 1].rowIndex)
            createNewRow(tableConsumiveis, c, mainTable.rows[j + 1].rowIndex)
            c++
        } else if (selectedOption == 'FÁRMACOS') {
            console.log(mainTable.rows[j + 1].cells[0].innerHTML)
            console.log(mainTable.rows[j + 1].rowIndex)
            createNewRow(tableFarmacos, f, mainTable.rows[j + 1].rowIndex)
            f++
        }else{
            console.log(mainTable.rows[j + 1].cells[0].innerHTML)
            console.log(mainTable.rows[j + 1].rowIndex)
            createNewRow(tableVacinas, v, mainTable.rows[j + 1].rowIndex)
            v++
        }
    }
    )
}

function createNewRow(elemento, i, index) {
    const td = document.createElement('td')
    const tr = document.createElement('tr')
    elemento.appendChild(tr).appendChild(td)
    elemento.getElementsByTagName('tr')[i].getElementsByTagName('td')[0].innerHTML = row[index].getElementsByTagName('td')[0].innerText
    const td1 = document.createElement('td')
    elemento.appendChild(tr).appendChild(td1)
    elemento.getElementsByTagName('tr')[i].getElementsByTagName('td')[1].innerHTML = row[index].getElementsByTagName('td')[1].innerText
    const td2 = document.createElement('td')
    elemento.appendChild(tr).appendChild(td2)
    elemento.getElementsByTagName('tr')[i].getElementsByTagName('td')[2].innerHTML = row[index].getElementsByTagName('td')[2].innerText
}
 */








/* for(let k=0;k<btnelements.length;k++){
    btnelements[k].addEventListener('click', function(){
        console.log(btnelements[k].innerHTML)
    })
} */


/*
btn.addEventListener('click', _ => {

    console.log(row.length)
    console.log(row[1].getElementsByTagName('td')[1].innerText)
    console.log(selectClasse.value)
    let selectedOption = selectClasse.value

    if (selectedOption == 'CONSUMIVEIS') {

        for(let j = 0;j<3;j++){
            tableConsumiveis.getElementsByTagName('tr')[1].getElementsByTagName('td')[j].innerHTML = row[1].getElementsByTagName('td')[0].innerText
        }
        tableConsumiveis.getElementsByTagName('tr')[1].getElementsByTagName('td')[0].innerHTML = row[1].getElementsByTagName('td')[0].innerText
        tableConsumiveis.getElementsByTagName('tr')[1].getElementsByTagName('td')[1].innerHTML = row[1].getElementsByTagName('td')[1].innerText
        tableConsumiveis.getElementsByTagName('tr')[1].getElementsByTagName('td')[2].innerHTML = row[1].getElementsByTagName('td')[2].innerText
        i++
    } else if (selectedOption == 'FÁRMACOS') {

    } else {

    }
})

function createNewRow(i) {
    const td = document.createElement('td')
    const tr = document.createElement('tr')
    tableConsumiveis.appendChild(tr).appendChild(td)
    tableConsumiveis.getElementsByTagName('tr')[i].getElementsByTagName('td')[0].innerHTML = row[1].getElementsByTagName('td')[0].innerText
    const td1 = document.createElement('td')
    tableConsumiveis.appendChild(tr).appendChild(td1)
    tableConsumiveis.getElementsByTagName('tr')[i].getElementsByTagName('td')[1].innerHTML = row[1].getElementsByTagName('td')[1].innerText
    const td2 = document.createElement('td')
    tableConsumiveis.appendChild(tr).appendChild(td2)
    tableConsumiveis.getElementsByTagName('tr')[i].getElementsByTagName('td')[2].innerHTML = row[1].getElementsByTagName('td')[2].innerText
}*/