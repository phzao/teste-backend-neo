import React, { Component }  from 'react';
import { PostData } from '../../services/Methods/API';

import serializeForm from 'form-serialize';

class BoxNewTask extends Component {
    constructor() {
      super();
      this.state = {
        list:[]
      }

      this.handle = this.handle.bind(this);
    }
    
    handle = async (event) => {
        event.preventDefault();
        const formData = serializeForm(event.target, { hash: true })
        const save = await PostData(formData);
        if (save.status==="success") {
            this.props.newTask(save.data)
        }
    }

    render() {
        return <div className="row">
                    <div className="col">
                        <form onSubmit={ this.handle }>
                            <div className="my-3 p-3 bg-white rounded shadow-sm">
                                <h6 className="border-bottom border-gray pb-2 mb-0">Adicionar Task</h6>
                                <span className="d-block text-right mt-3">
                                    <input className="form-control form-control-sm" maxLength={50} type="text" name="title" placeholder="Titulo da Task" />
                                </span>
                                <div className="pt-2 text-right">
                                    <button type="submit" className="btn btn-success btn-sm" >Adicionar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    }
}

export default BoxNewTask;