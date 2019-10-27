import React, { Component }  from 'react';
import { GetData, PutData } from '../../services/Methods/API';
import ModalConfirmBasic from '../Modal';
import { BoxItem } from './BoxItem';

class BoxList extends Component {
    constructor() {
      super();
      this.state = {
        list:[],
        document:{},
        queryList: "",
        queryBlacklist: "",
        isBlacklistOffOpen: false,
        isOpenDelete: false,
        isBlacklistOpen: false
      }
    }

    BlacklistOffOpen = () => this.setState({isBlacklistOffOpen: true});
    BlacklistOffClose = () => this.setState({isBlacklistOffOpen: false});

    BlacklistOpen = () => this.setState({isBlacklistOpen: true});
    BlacklistClose = () => this.setState({isBlacklistOpen: false});
    
    getData = async () => {
      const list = await GetData("documents");
      if (list.status=== "success") {
        this.setState({list: list.data});
      }
    }      
  
    componentDidMount() {
        this.getData()
    }

    componentDidUpdate() {
        const { addItem } = this.props
        if (typeof addItem === "undefined") {
            return 
        }
        if (Object.keys(addItem).length>0) {
            this.getData()
            this.props.refreshItem()
        }
    }

    setBlacklist = async (id) => {
        const status = await PutData("", `blacklist/add/${id}`)

        if (status===204) {
            this.getData()

            return
        }
        this.clearDocument()
    }

    clearDocument = () => this.setState({document: {}})

    unsetBlacklist = async (id) => {
        const status = await PutData("", `blacklist/del/${id}`)

        if (status===204) {
            this.getData()

            return
        }
        this.clearDocument()
    }
  
    render() {
      const { list, isBlacklistOffOpen, queryList, isBlacklistOpen, queryBlacklist, document } = this.state

      return (
          <div>
              <ModalConfirmBasic
                content={`Remover "${typeof document.cpf==="undefined"?document.cnpj:document.cpf}" da blacklist?`}
                title={"Confirmar Remoção"}
                modalIsOpen={isBlacklistOffOpen}
                onConfirm={()=>{
                    this.BlacklistOffClose()
                    this.unsetBlacklist(document._id)
                }}
                onCancel={()=>this.setState({document: {}}, ()=>this.BlacklistOffClose())}
               />

            <ModalConfirmBasic
                content={`Confirmar a inclusão de "${typeof document.cpf==="undefined"?document.cnpj:document.cpf}" na blacklist?`}
                title={"Confirmar Inclusão"}
                modalIsOpen={isBlacklistOpen}
                onConfirm={()=>{
                    this.BlacklistClose()
                    this.setBlacklist(document._id)
                }}
                onCancel={()=>this.setState({document: {}}, ()=>this.BlacklistClose())}
               />

            <div className="row">
                <div className="col-md-6">
                    <div className="my-3 p-3 bg-white rounded shadow-sm">
                        <div className="row">
                            <div className="col-md">
                                <h6 className="pb-2 mb-0 title-list">Últimos 10 registros - CPF/CNPJ</h6>
                            </div>
                            <div className="col-md-5">
                                <input 
                                    type="text"
                                    onKeyUp={(input)=>this.setState({queryList:input.target.value})} 
                                    className="form-control form-control-sm mr-sm-2 inputSearch-position" 
                                    placeholder="filtrar " />
                            </div>
                        </div>
                        <div className="row">
                            <div className="col border-bottom border-gray"></div>
                        </div>
                    {typeof list !== "undefined" && 
                        list.length > 0 && 
                        list
                            .filter(document=>document.status!=='blocked')
                            .filter(document=>{
                                if (queryList.length===0) {
                                    return document;
                                }

                                if (typeof document.cnpj !== "undefined" && document.cnpj.includes(queryList)) {
                                    return document;
                                }

                                if (typeof document.cpf !== "undefined" && document.cpf.includes(queryList)) {
                                    return document;
                                }

                                return false
                            })
                            .map((document, i)=>{
                                return <BoxItem
                                            key={i}
                                            document={document}
                                            onBlacklist={()=>this.setState({document: document}, ()=>this.BlacklistOpen())} 
                                            />
                            })}
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="my-3 p-3 bg-white rounded shadow-sm">
                        <div className="row">
                            <div className="col-md">
                                <h6 className="pb-2 mb-0 title-list">Blacklist</h6>
                            </div>
                            <div className="col-md-5">
                                <input 
                                    type="text" 
                                    onKeyUp={(input)=>this.setState({queryBlacklist:input.target.value})} 
                                    className="form-control form-control-sm mr-sm-2 inputSearch-position" 
                                    placeholder="filtrar por titulo" />
                            </div>
                        </div>
                        <div className="row">
                            <div className="col border-bottom border-gray"></div>
                        </div>
                        
                        {typeof list !== "undefined" && 
                        list.length > 0 && 
                        list
                            .filter(document=>document.status==='blocked')
                            .filter(document=>{
                                if (queryBlacklist.length===0) {
                                    return document;
                                }

                                if (typeof document.cnpj !== "undefined" && document.cnpj.includes(queryBlacklist)) {
                                    return document;
                                }

                                if (typeof document.cpf !== "undefined" && document.cpf.includes(queryBlacklist)) {
                                    return document;
                                }

                                return false
                            }).map((document, i)=>{
                                return <BoxItem
                                            key={i} 
                                            document={document} 
                                            offBlacklist={()=>{
                                                this.setState({document: document}, ()=>this.BlacklistOffOpen())
                                            }
                                            } />
                            })}
                    </div>
                </div>
            </div>
        </div>
      );
    }
  }
  
export default BoxList;