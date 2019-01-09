import SettingsModal from 'flarum/components/SettingsModal';

export default class QueueSettingsModal extends SettingsModal {
  className() {
    return 'QueueSettingsModal Modal--small';
  }

  title() {
    return app.translator.trans('zhishiq.queue.admin.setting_title');
  }

  form() {
    return [
      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.queue.admin.app_id_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.queue.app_id')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.queue.admin.subscribe_endpoint_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.queue.subscribe_endpoint')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.queue.admin.app_client_key_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.queue.app_client_key')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.queue.admin.push_endpoint_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.queue.push_endpoint')}/>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('zhishiq.queue.admin.app_server_key_label')}</label>
        <input className="FormControl" bidi={this.setting('zhishiq.queue.app_server_key')}/>
      </div>,
    ];
  }
}
