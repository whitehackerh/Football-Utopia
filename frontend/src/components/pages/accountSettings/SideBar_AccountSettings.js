import { Link } from "react-router-dom";

const SideBar_AccountSettings = () => {
    const style = {
        position: 'sticky',
        width: '300px',
        border: '1px solid blue',
        margin: '10px',
        padding: '10px',
        float: 'left'
    }
    return (
        <div style={style}>
            <Link to="/basicProfileSettings">Basic Profile</Link><br></br><br></br>
            <Link to="/imageSettings">Profile Picture</Link><br></br><br></br>
            <Link to="/detailProfileSettings">Detail Profile</Link> 
        </div>
    )
}

export default SideBar_AccountSettings;