export const url = process.env.REACT_APP_API_URL

export const headerJson = {
    'Accept': 'application/json',
    'content-type': 'application/json',
}

export const GetData = async (parameters = "") => {
    const res = await fetch(`${url}${parameters}`, {method: 'GET',headers: headerJson})
    const json = await res.json()
    
    return json
}

export const PostData = async (data) => {
    const res = await fetch(`${url}documents`, {
        method: 'POST',
        headers: headerJson,
        body: JSON.stringify(data)
    })

    const json = await res.json()

    return json
}

export const PutData = async (id, parameters = "") => {
    const res = await fetch(`${url}documents/${id}${parameters}`, {
        method: 'PUT',
        headers: headerJson,
        body: ''
    })

    return res.status
}

export const DeleteData = async (id) => {
    const res = await fetch(`${url}documents/${id}`, {
        method: 'DELETE',
        headers: headerJson,
        body: ''
    })

    return res.status
}