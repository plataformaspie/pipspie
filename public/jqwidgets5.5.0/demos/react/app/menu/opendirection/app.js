import React from 'react';
import ReactDOM from 'react-dom';

import JqxMenu from '../../../jqwidgets-react/react_jqxmenu.js';

class App extends React.Component {
    componentDidMount() {
        this.refs.myMenu.setItemOpenDirection('Services', 'left', 'up');
        this.refs.myMenu.setItemOpenDirection('ContactUs', 'left', 'down');
    }
    render() {
        let menuInnerHtml =
            `
           <ul>
                <li style='width: 80px;'><a href='#'>About Us</a>
                    <ul>
                        <li><a href='#'>History</a></li>
                        <li><a href='#'>Our Vision</a></li>
                        <li><a href='#'>The Team</a>
                            <ul>
                                <li><a href='#'>Brigita</a></li>
                                <li><a href='#'>John</a></li>
                                <li><a href='#'>Michael</a></li>
                                <li><a href='#'>Peter</a></li>
                                <li><a href='#'>Sarah</a></li>
                            </ul>
                        </li>
                        <li><a href='#'>Clients</a></li>
                        <li><a href='#'>Testimonials</a></li>
                        <li><a href='#'>Press</a></li>
                        <li><a href='#'>FAQs</a></li>
                    </ul>
                </li>
                <li id='Services'><a href='#'>Services</a> 
                    <ul>
                        <li><a href='#'>Delivery</a></li>
                        <li><a href='#'>Shop Online</a></li>
                        <li><a href='#'>Support</a></li>
                    </ul>
                </li>
                    <li id='ContactUs'><a href='#'>Contact Us</a>
                    <ul>
                        <li><a href='#'>Enquiry Form</a></li>
                        <li><a href='#'>Map &amp; Driving Directions</a></li>
                        <li><a href='#'>Your Feedback</a></li>
                    </ul>
                </li>
            </ul>
            `;
        return (
            <div style={{ marginTop: 100, width: 310 }}>
                <JqxMenu ref='myMenu'
                    width={310} height={30} template={menuInnerHtml}
                    mode={'horizontal'} showTopLevelArrows={true}
                />
            </div>
        )
    }
}

ReactDOM.render(<App />, document.getElementById('app'));
