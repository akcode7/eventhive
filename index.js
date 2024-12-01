const hideOnClick = () =>{
    const menuContent = document.getElementById('menu-inside');
    if(menuContent.className === 'hidden'){
        menuContent.className += "block";
    }else{
        menuContent.className += "hidden";
    }
}