import React, { Component } from 'react';
import './App.css';
import { MyBody } from './components/style/Body';
import { NavBar } from './components/style/NavBar';
import BoxTaskList from './components/style/BoxTaskList';
import BoxNewTask from './components/style/BoxNewTask';
import Modal from 'react-modal';

Modal.setAppElement('#root')

class App extends Component {
  constructor() {
    super();
    this.state = {
      task:{}
    }
  }

  render() {
    const { task } = this.state
    return (
      <MyBody>
        <NavBar />
        <BoxNewTask 
          newTask={(task)=>this.setState({task: task})} />
        <BoxTaskList 
          addTask={task}
          refreshTask={()=>this.setState({task:{}})} />
      </MyBody>
    );
  }
}

export default App;
