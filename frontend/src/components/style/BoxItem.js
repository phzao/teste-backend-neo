import React  from 'react';
import { formatCNPJ, formatCPF } from '../../helpers/FormatDocument';

export const BoxItem = ({ document, onBlacklist, offBlacklist}) =>
<div className="row border-bottom border-gray mt-2 mt-md-2">
    <div className="col-md text-center pt-2">
        <span className="d-block text-gray-dark document-list-item">
            {typeof document.cpf === "undefined" ? formatCNPJ(document.cnpj): 
                                                   formatCPF(document.cpf) }
        </span>
    </div>
    {document.status==="enable" &&
        <div className="col-md-2 text-center pr-3">
            <button 
                type="button" 
                className="btn" 
                onClick={()=>onBlacklist()} 
                title="Adicionar a blacklist">
                <i className="fa fa-ban ban-check"></i></button>
        </div> }
    {document.status==="blocked" &&
        <div className="col-md-2 text-center pr-3">
            <button 
                type="button" 
                className="btn" 
                onClick={()=>offBlacklist()} 
                title="Remover da blacklist">
                <i className="fa fa-check done-check"></i></button>
        </div> }
</div>