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

    var tableRef = ingredientsTable.querySelector('tbody');
    tableRef.appendChild(tr);
    tableRef.setAttribute('data-max_index', idx++);
}

addInputIngredient = function (idx, name, value, size) {
    var td = document.createElement('td');
    value = value || '';
    var str = '<INPUT type="text" name=ingredient[' + idx + '][' + name + '] maxlength="' + size + '" size="' + size + '" value="' + String(value) + '"/>';
    td.innerHTML = str;
    return td;
}

printIngredients = function () {
    for (var i = 0; i < data.i.length; i++) {
        var ingredient = data.i[i];
        addIngredient(i, ingredient.name, ingredient.count, ingredient.unit)
    }
};