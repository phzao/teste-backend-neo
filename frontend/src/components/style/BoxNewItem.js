import React, { Component }  from 'react';
import { PostData, GetData } from '../../services/Methods/API';
import serializeForm from 'form-serialize';
import { BoxInput } from './BoxInput';
import ModalDetails from '../ModalDetails';

class BoxNewItem extends Component {
    constructor() {
      super();
      this.state = {
        list:[],
        query: "",
        document: {},
        documentData: {},
        errorAdd: "",
        errorSearch: "",
        countAdd: "",
        countSearch: "",
        isDetailsOpen: false,
        loading: false,
      }

      this.handle = this.handle.bind(this);
    }

    DetailsOpen = () => this.setState({isDetailsOpen: true});
    DetailsClose = () => this.setState({isDetailsOpen: false});

    loadingStart = () => this.setState({loading: true});
    loadingStop = () => this.setState({loading: false});

    handleError = (errors, type) => {
        let details = "";

        if (typeof errors.cpf !== "undefined") {
            details = errors.cpf.join(" / ");
        }

        if (typeof errors.cnpj !== "undefined") {
            details = errors.cnpj.join("/");
        }

        if (type === "add") {
            this.setState({errorAdd: details})
            return ;
        }

        this.setState({errorSearch: details})    
    }
    
    handle = async (event) => {
        event.preventDefault();
        const formData = serializeForm(event.target, { hash: true })

        if (formData.document.length !== 11 && formData.document.length !== 14) {
            this.setState({errorAdd: "O cadastro requer um número com 11 ou 14 digitos."})
            return ;
        }

        if (formData.document.length === 11) {
            formData.cpf = formData.document;
        }

        if (formData.document.length === 14) {
            formData.cnpj = formData.document;
        }

        const save = await PostData(formData);
    
        if (save.status==="success") {
            this.props.newItem(save.data)

            return ;
        }

        if (save.status==="fail") {
            this.handleError(save.data, "add");
        }
    }

    handleSearch = async (event) => {
        this.DetailsOpen();
        this.loadingStart();
        event.preventDefault();
        const formData = serializeForm(event.target, { hash: true })


        if (formData.length === 0) {
            return ;
        }

        if (formData.document.length !== 11 && formData.document.length !== 14) {
            this.setState({errorAdd: "O cadastro requer um número com 11 ou 14 digitos."})
            return ;
        }

        let query = "";

        if (formData.document.length === 11) {
            query = `${formData.document}/cpf`;
        }

        if (formData.document.length === 14) {
            query = `${formData.document}/cnpj`;
        }

        this.setState({query: formData.document});
        const search = await GetData(`documents/${query}`);
    
        if (search.status==="success") {
            this.setState({documentData: search.data});
            this.loadingStop();
            return ;
        }

        if (search.status==="fail") {
            this.handleError(search.data);
            this.loadingStop();
            this.DetailsClose();
        }
    }

    getDetailsType = (length, type) => {
        let index = type==="add"? "countAdd": "countSearch";
        let indexDescription = length <= 11 ? "CPF": "CNPJ";

        if (length>0) {
            this.setState({[index]: `${indexDescription} / (${length})`})
        } else {
            this.setState({[index]: ``})
        }
    }

    render() {
        const { errorAdd, countAdd, isDetailsOpen, errorSearch, query, loading, documentData, countSearch } = this.state

        return <div className="row">
                <ModalDetails
                    document={documentData}
                    query={query}
                    modalIsOpen={isDetailsOpen}
                    loadSpin={loading}
                    onConfirm={()=>{
                        this.DetailsClose();
                        this.clearDocument();
                        this.setState({documentData: {}}, ()=>this.DetailsClose());
                    }}
                    onCancel={()=>this.setState({documentData: {}}, ()=>this.DetailsClose())}
                />
                    <div className="col-md-6">
                        <BoxInput 
                            btnDescription = "Adicionar"
                            countInput = {(input)=>this.getDetailsType(input.target.value.length, "add")}
                            showInput = {countAdd}
                            buttonType = "btn-success"
                            handleForm = {this.handle}
                            maxLength={14}
                            description = "Incluir"
                            placeholderDescription = "Informe um CPF/CNPJ para cadastro"
                            errorMsg = {errorAdd}
                         />
                    </div>
                    <div className="col-md-6">
                        <BoxInput 
                            btnDescription = "Pesquisar"
                            countInput = {(input)=>this.getDetailsType(input.target.value.length)}
                            showInput = {countSearch}
                            buttonType = "btn-primary"
                            maxLength={14}
                            handleForm = {(event)=>{
                                event.preventDefault();
                                if (event.target.document.value.length===0) {
                                    return;
                                }
                                this.handleSearch(event);
                            }}
                            description = "Pesquisar "
                            placeholderDescription = "Informe um CPF/CNPJ para pesquisar"
                            errorMsg = {errorSearch}
                         />
                    </div>
                </div>
    }
}

export default BoxNewItem;