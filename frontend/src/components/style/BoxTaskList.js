import React, { Component }  from 'react';
import { GetData, PutData, DeleteData } from '../../services/Methods/API';
import { BoxItemTask } from './BoxItemTask';
import ModalConfirmBasic from '../Modal';

class BoxTaskList extends Component {
    constructor() {
      super();
      this.state = {
        list:[],
        task:{},
        queryOpen: "",
        queryCloseDone: "",
        isOpenReopen: false,
        isOpenDelete: false,
        isOpenDone: false
      }
    }

    ReopenOpen = () => this.setState({isOpenReopen: true});
    ReopenClose = () => this.setState({isOpenReopen: false});

    DeleteOpen = () => this.setState({isOpenDelete: true});
    DeleteClose = () => this.setState({isOpenDelete: false});

    DoneOpen = () => this.setState({isOpenDone: true});
    DoneClose = () => this.setState({isOpenDone: false});
    
    getData = async () => {
      const list = await GetData();
      if (list.status=== "success") {
        this.setState({list: list.data});
      }
    }

    generateColor = ()=>{
        return '#' +  Math.random().toString(16).substr(-6);
      }
  
    componentDidMount() {
        this.getData()
    }

    componentDidUpdate() {
        const { addTask } = this.props
        if (typeof addTask === "undefined") {
            return 
        }
        if (Object.keys(addTask).length>0) {
            this.getData()
            this.props.refreshTask()
        }
    }

    setDone = async (id) => {
        const status = await PutData(id, "/done")

        if (status===204) {
            this.getData()

            return
        }
        this.clearTask()
    }

    clearTask = () => {
        this.setState({task: {}})
    }

    setOpen = async (id) => {
        const status = await PutData(id, "/open")

        if (status===204) {
            this.getData()

            return
        }
        this.clearTask()
    }

    delete = async (id) => {
        const status = await DeleteData(id)

        if (status===204) {
            this.getData()

            return 
        }
        this.clearTask()
    }
  
    render() {
      const { list, isOpenReopen, isOpenDelete, queryCloseDone, queryOpen, isOpenDone, task } = this.state

      return (
          <div>
              <ModalConfirmBasic
                content={`A task "${task.title}" será reaberta, confirma ação?`}
                title={"Confirmar reabertura"}
                modalIsOpen={isOpenReopen}
                onConfirm={()=>{
                    this.ReopenClose()
                    this.setOpen(task.id)
                }}
                onCancel={()=>{
                    this.setState({task: {}}, ()=>this.ReopenClose())
                }}
               />

            <ModalConfirmBasic
                content={`A task "${task.title}" será setada como concluída, confirma ação?`}
                title={"Confirmar conclusão"}
                modalIsOpen={isOpenDone}
                onConfirm={()=>{
                    this.DoneClose()
                    this.setDone(task.id)
                }}
                onCancel={()=>{
                    this.setState({task: {}}, ()=>this.DoneClose())
                }}
               />

            <ModalConfirmBasic
                content={`A task "${task.title}" será excluída, confirma ação?`}
                title={"Confirmar exclusão"}
                modalIsOpen={isOpenDelete}
                onConfirm={()=>{
                    this.DeleteClose()
                    this.delete(task.id)
                }}
                onCancel={()=>{
                    this.setState({task: {}}, ()=>this.DeleteClose())
                }}
               />
            <div className="row">
                <div className="col-md-6">
                    <div className="my-3 p-3 bg-white rounded shadow-sm">
                        <div className="row">
                            <div className="col-md-4">
                                <h6 className="pb-2 mb-0 title-list">Em aberto</h6>
                            </div>
                            <div className="col-md">
                                <input type="text" onKeyUp={(input)=>this.setState({queryOpen:input.target.value})} className="form-control form-control-sm mr-sm-2 inputSearch-position" placeholder="filtrar por titulo" />
                            </div>
                        </div>
                        <div className="row">
                            <div className="col border-bottom border-gray"></div>
                        </div>
                    {typeof list !== "undefined" && 
                        list.length > 0 && 
                        list
                            .filter(task=>task.deleted_at===null && task.done_at===null)
                            .filter(task=>{
                                const query = queryOpen.toLocaleLowerCase();
                                const title = task.title.toLocaleLowerCase();

                                if (query.length===0) {
                                    return task;
                                }

                                if (title.includes(query)) {
                                    return task;
                                }
                                return false
                            })
                            .map((task, i)=>{
                                const colorBox = this.generateColor()
                                return <BoxItemTask 
                                            key={i} 
                                            colorBox={colorBox} 
                                            task={task} 
                                            onDone={()=>this.setState({task: task}, ()=>this.DoneOpen())} 
                                            onDelete={()=>this.setState({task: task}, ()=>this.DeleteOpen())} />
                            })}
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="my-3 p-3 bg-white rounded shadow-sm">
                        <div className="row">
                            <div className="col-md-6">
                                <h6 className="pb-2 mb-0 title-list">Concluído / Removido</h6>
                            </div>
                            <div className="col-md pt-md-2">
                                <input type="text" onKeyUp={(input)=>this.setState({queryCloseDone:input.target.value})} className="form-control form-control-sm mr-sm-2 inputSearch-position" placeholder="filtrar por titulo" />
                            </div>
                        </div>
                        <div className="row">
                            <div className="col border-bottom border-gray"></div>
                        </div>
                        
                        {typeof list !== "undefined" && 
                        list.length > 0 && 
                        list
                            .filter(task=>task.deleted_at!==null || task.done_at!==null)
                            .filter(task=>{
                                const query = queryCloseDone.toLocaleLowerCase();
                                const title = task.title.toLocaleLowerCase();

                                if (query.length===0) {
                                    return task;
                                }
                                
                                if (title.includes(query)) {
                                    return task;
                                }
                                return false
                            })
                            .map((task, i)=>{
                                const colorBox = this.generateColor()
                                return <BoxItemTask 
                                            key={i} 
                                            colorBox={colorBox} 
                                            task={task} 
                                            onOpen={()=>{
                                                this.setState({task: task}, ()=>this.ReopenOpen())
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
  
export default BoxTaskList;