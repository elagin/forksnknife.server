/* +
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


removeIngredient = function (el) {
    el.parentNode.remove();
};

removeStep = function (el) {
    el.parentNode.remove();
};

addIngredient = function () {
    var idx = ingredientsTable.getAttribute('data-max_index');
    var tr = document.createElement('tr');
    var name = '<td><INPUT type="text" name=ingredient[' + idx + '][name] maxlength="50" size="50" value=""/></td>';
    var count = '<td><INPUT type="text" name=ingredient[' + idx + '][count] maxlength="5" size="5" value=""/></td>';
    var unit = '<td><INPUT type="text" name=ingredient[' + idx + '][unit] maxlength="10" size="10" value=""/></td>';
    var del = '<td onclick="removeIngredient(this)">Удалить</td>';
    var str = name + count + unit + del;
    tr.innerHTML = str;
    ingredientsTable.appendChild(tr);
    ingredientsTable.setAttribute('data-max_index', idx++);
}