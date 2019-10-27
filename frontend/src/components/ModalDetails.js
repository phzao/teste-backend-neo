import React, {Component} from 'react'
import Modal from 'react-modal';
import { formatCNPJ, formatCPF, translateStatus } from '../helpers/FormatDocument';

const customStyles = {
    content : {
      top                   : '50%',
      left                  : '50%',
      right                 : 'auto',
      bottom                : 'auto',
      width: 500,
      marginRight           : '-50%',
      transform             : 'translate(-50%, -50%)'
    }
  };

class ModalDetails extends Component {
    constructor() {
        super()
        this.state = {
            modalIsOpen: false
        }
    }

    handleModal = () => this.setState({modalIsOpen: !this.state.modalIsOpen})
    
    render() {
        const { modalIsOpen, document, query, loadSpin } = this.props

        return <Modal
                    isOpen={modalIsOpen}
                    style={customStyles}
                    contentLabel="Example Modal"
                    >
                    <div className="row">
                        <div className="col border-bottom">
                            <span className="text-center">
                                <h4> Retorno da pesquisa </h4>
                            </span>
                        </div>
                    </div>
                    {loadSpin === true ? 
                        <div className="row mt-4 mb-4 p-3">
                            <div className="col text-center"><i className="fa fa-spinner"></i></div>
                        </div>:
                    <div>
                        <div className="row mt-4 mb-4 p-3">
                            <div className="col text-center">Buscou - {query}</div>
                        </div>
                        {Object.keys(document).length > 0 &&
                        <ul className="list-group list-group-flush">
                            <li className="list-group-item"><small className="type-list">{typeof document[0].cpf !== "undefined" ? "CPF": "CNPJ"}</small> : 
                                                    {typeof document[0].cpf !== "undefined" ? 
                                                                                        formatCPF(document[0].cpf): 
                                                                                        formatCNPJ(document[0].cnpj)}</li>
                            <li className="list-group-item"><small className="type-list">Situação</small>: {translateStatus(document[0].status)}</li>
                            <li className="list-group-item"><small className="type-list">Ultima atualização</small>: {document[0].updated_at}</li>
                            <li className="list-group-item"><small className="type-list">Registrado em</small>: {document[0].created_at}</li>
                        </ul>}
                    <div className="row pt-3">
                        <div className="col text-right">
                            <button type="button" className="btn btn-sm btn-success" onClick={()=>this.props.onCancel()}>Fechar</button>
                        </div>
                    </div>
                    </div>}
            </Modal>
    }
}

export default ModalDetails;