import SideBar_AccountSettings from './SideBar_AccountSettings'; 

const DetailProfileSettings = () => {

    /** css */
    const mainContents = {
        float: 'left',
        margin: '10px',
        width: 'calc(100% - 362px)'
    }

    return (
        <div>
            <SideBar_AccountSettings />
            <div style={mainContents}>
                Detail
            </div>
        </div>
    )
}

export default DetailProfileSettings;