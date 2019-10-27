
export const formatCPF = (number) => {
    
    return number.substring(0,3)+"."+
           number.substring(3,6)+"."+
           number.substring(6,9)+"-"+
           number.substring(9,11)
}

export const formatCNPJ = (number) => {
    
    return number.substring(0,2)+"."+
           number.substring(2,5)+"."+
           number.substring(5,8)+"/"+
           number.substring(8,12)+"-"+
           number.substring(12,14)
}

export const translateStatus = (status) => {
    if (status === "enable") {
        return "Ativo";
    }

    if (status === "disable") {
        return "Inativo";
    }

    if (status === "blocked") {
        return "Blacklist";
    }
}