/* +
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


removeIngredient = function (el) {
    el.parentNode.parentNode.remove();
};

removeStep = function (el) {
    el.parentNode.remove();
};

addIngredient = function (idx, name, count, unit) {
    //var idx = ingredientsTable.getAttribute('data-max_index');
    var tr = document.createElement('tr');
    
    var tdName = addInputIngredient(idx, 'name', name, 50)
    tr.appendChild(tdName);

    var tdCount = addInputIngredient(idx, 'count', count, 5)
    tr.appendChild(tdCount);

    var tdUnit = addInputIngredient(idx, 'unit', unit, 10)
    tr.appendChild(tdUnit);
    
    var tdDel = document.createElement('td');
    tdDel.innerHTML = '<button onclick="removeIngredient(this)">Удалить</button>';
    tr.appendChild(tdDel);

//    var nameInput = addInputIngredient(idx, 'name', "", 50);
//    var countInput = addInputIngredient(idx, 'count', "", 5);
//    var unitInput = addInputIngredient(idx, 'unit', "", 10);
//    
//    var del = '<td onclick="removeIngredient(this)">Удалить</td>';
//    var str = name + count + unit + del;
//    tr.innerHTML = str;
//    var tableRef = ingredientsTable.getElementsByTagName('tbody')[0];
    var tableRef = ingredientsTable.querySelector('tbody');
    //var newRow   = tableRef.insertRow(tableRef.rows.length);
    tableRef.appendChild(tr);
//    var newCell  = newRow.insertCell(0);
    //var newText  = document.createTextNode('New row');
//    newCell.appendChild(tr);
    tableRef.setAttribute('data-max_index', idx++);
//    ingredientsTable.tbody.appendChild(tr);
//    ingredientsTable.tbody.setAttribute('data-max_index', idx++);
}

addInputIngredient = function (idx, name, value, size) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<INPUT type="text" name=ingredient[' + idx + '][' + name + '] maxlength="' + size + '" size="' + size + '" value="' + String(value) + '"/>';
    td.innerHTML = str;
    return td;
    //return '<td><INPUT type="text" name=ingredient[' + idx + '][' + name + '] maxlength="' + size + '" size="' + size + '" value="' + value + '"/></td>';
}

printIngredients = function(){
    for(var i = 0; i < data.i.length; i++){
        var ingredient = data.i[i];
        addIngredient(i, ingredient.name, ingredient.count, ingredient.unit)
    }
};