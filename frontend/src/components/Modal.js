import React, {Component} from 'react'
import Modal from 'react-modal';

const customStyles = {
    content : {
      top                   : '50%',
      left                  : '50%',
      right                 : 'auto',
      bottom                : 'auto',
      marginRight           : '-50%',
      transform             : 'translate(-50%, -50%)'
    }
  };

class ModalConfirmBasic extends Component {
    constructor() {
        super()
        this.state = {
            modalIsOpen: false
        }
    }

    handleModal = () => this.setState({modalIsOpen: !this.state.modalIsOpen})
    
    render() {
        const { modalIsOpen, title, content } = this.props

        return <Modal
                    isOpen={modalIsOpen}
                    // onAfterOpen={this.afterOpenModal}
                    // onRequestClose={this.props.closeModal}
                    style={customStyles}
                    contentLabel="Example Modal"
                    >
                    <div className="row">
                        <div className="col">
                            <span className="text-center">
                                <h4> { title } </h4>
                            </span>
                        </div>
                    </div>
                    <div className="row mt-4 mb-4 p-3">
                        <div className="col">{content}</div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                        </div>
                        <div className="col-md-3 text-right">
                            <button type="button" className="btn btn-sm btn-success" onClick={()=>this.props.onConfirm()}>Confirmar</button>
                        </div>
                        <div className="col-md-3 text-right">
                            <button type="button" className="btn btn-sm btn-danger" onClick={()=>this.props.onCancel()}>Cancelar</button>
                        </div>
                    </div>
            </Modal>
    }
}

export default ModalConfirmBasic;