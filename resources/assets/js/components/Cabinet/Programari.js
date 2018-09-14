
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import Pusher from 'pusher-js';
import {NotificationContainer, NotificationManager} from 'react-notifications';
import 'react-notifications/lib/notifications.css';
if(document.getElementById('cabviewprog'))
{
    
    const Token = window.config.csrfToken;
    const API = 'https://stomatime.com/cabinet/programari';
    class Modal extends Component{
        constructor(props){
            super(props);

            this.confProg=this.confProg.bind(this);
        }
        confProg(id_doctor,id_client,id){
            axios.post(`https://stomatime.com/cabinet/confirmare`,
            { 
            id_medic: id_doctor,
            id_client: id_client,
            id:id,
            csrfToken: Token 
            }
            )
            .then(res => {
                switch (res.data.status) {
                    case 'fail': {
                        NotificationManager.error('Error', res.data.msg, 3000);
                        break;
                    }
                    case 'success': {
                        NotificationManager.success('Success', res.data.msg, 3000);
                        this.props.update();
                        this.forceUpdate();
                        break;
                    }
                }
            })
        }
        render()
       
        {
            var data= this.props.data;
            return(
                <div className="text-center">
                <button type="button" className="btn btn-primary" data-toggle="modal" data-target={"#set"+data.id}>
                <i className="fa fa-pencil-square-o"/>
                </button>
                <div className="modal" id={"set"+data.id}>
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">{data.pacient} | {data.medic}</h4>
                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div className="modal-body">   
                    {data.status==0 && data.confirmat==1 &&
                            <div>
                        <p>To confirm the appointment, click on the button below</p>
                         <button type="submit" id={"conf"+data.id} onClick={this.confProg.bind(this,data.id_doctor,data.id_client,data.id)} className="btn btn-info">Confirm</button>
                        </div>}     
                    </div>
                    <div className="modal-footer">
                        <button type="button" className="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>
                </div>
            );
        }
    }
    class Row extends Component{

        render()
        {
            var prog=this.props.programare;
            return(
                <tr>
                    <td>{prog.medic}</td>
                    <td>{prog.pacient}</td>
                    <td>+{prog.numar}</td>
                    <td>{prog.data}</td>
                    <td>{prog.ora}</td>
                    <td>{prog.status==0 ? <span className="badge badge-info">Wainting</span> : prog.status==2 ? <span className="badge badge-danger">Canceled</span> :<span className="badge badge-success">Accepted</span> }</td>
                   <td>{prog.confirmat==0 ? <span className="badge badge-info">Unconfirmed</span> : <span className="badge badge-success">Confirmed</span>}</td>
                    <td><Modal update={this.props.update} data={prog}/></td>
                    </tr>
            );
        }
    }
    class Main extends Component{
        constructor(props)
        {
            super(props);
            this.state = {
                date: []
              };
              this.updateData=this.updateData.bind(this);
        }
        componentWillMount() 
        {
         
            this.pusher = new Pusher('3b97862bc0344790efbc', {
             cluster: 'eu',
             encrypted: true
           });
            this.channel = this.pusher.subscribe('programare'+window.config.ID);  
        }
        componentDidMount()
        {
           this.updateData();
            this.channel.bind('new', data => {
                NotificationManager.success('Success', data.msg, 3000);
                this.updateData();
            }, this);
        }
        updateData()
        {
            axios.get(API)
            .then((res) => {
            this.setState({
                date:res.data            
            });
            })
        }
        render()
        {
            var rows=[];
            this.state.date.forEach((programare,key)=>{
                rows.push(<Row programare={programare} update={this.updateData} key={key}/>)
            });
            return(
                <div>
               <table className="table text-center">
                   <thead>
                       <tr>
                            <th>Doctor</th>
                           <th>Patient</th>
                           <th>Number</th>
                           <th>Date</th>
                           <th>Time</th>
                           <th>Status</th>
                           <th>Confirmat</th>
                           <th>Settings</th>
                        </tr>
                    </thead>
                    <tbody>
                        {rows}
                </tbody>
                    <tfoot>
                    <tr>
                        <th>Doctor</th>
                        <th>Patient</th>
                        <th>Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Confirmat</th>
                        <th>Settings</th>
                    </tr>
                </tfoot>
                   </table>
                   <NotificationContainer/>
                   </div>
            );
        }
    }
    ReactDOM.render(<Main/>, document.getElementById('cabviewprog'));
}