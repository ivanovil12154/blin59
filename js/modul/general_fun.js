function elem_remove_all(gelem){
    elems = gelem.querySelectorAll("*");
    if (elems != null){
        for (let element of elems) {
            element.remove();
        };
    };    
};