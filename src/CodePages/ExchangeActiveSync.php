<?php
namespace YOCLIB\WBXML\CodePages;

use YOCLIB\WBXML\WBXMLCodePage;

class ExchangeActiveSync{

	public static function getCodePages(): array{
		return [
			0	=> new WBXMLCodePage(0,[
				0x05	=> 'Sync',
				0x06	=> 'Responses',
				0x07	=> 'Add',
				0x08	=> 'Change',
				0x09	=> 'Delete',
				0x0A	=> 'Fetch',
				0x0B	=> 'SyncKey',
				0x0C	=> 'ClientId',
				0x0D	=> 'ServerId',
				0x0E	=> 'Status',
				0x0F	=> 'Collection',
				0x10	=> 'Class',
				0x12	=> 'CollectionId',
				0x13	=> 'GetChanges',
				0x14	=> 'MoreAvailable',
				0x15	=> 'WindowSize',
				0x16	=> 'Commands',
				0x17	=> 'Options',
				0x18	=> 'FilterType',

				0x1B	=> 'Conflict',
				0x1C	=> 'Collections',
				0x1D	=> 'ApplicationData',
				0x1E	=> 'DeletesAsMoves',
				0x20	=> 'Supported',
				0x21	=> 'SoftDelete',
				0x22	=> 'MIMESupport',
				0x23	=> 'MIMETruncation',
				0x24	=> 'Wait',                // 12.1, 14.0, 14.1, 16.0, 16.1
				0x25	=> 'Limit',               // 12.1, 14.0, 14.1, 16.0, 16.1
				0x26	=> 'Partial',             // 12.1, 14.0, 14.1, 16.0, 16.1
				0x27	=> 'ConversationMode',    // 14.0, 14.1, 16.0, 16.1
				0x28	=> 'MaxItems',            // 14.0, 14.1, 16.0, 16.1
				0x29	=> 'HeartbeatInterval',   // 14.0, 14.1, 16.0, 16.1
			],'AirSync:','airsync'),
			1	=> new WBXMLCodePage(1,[],'Contacts:','contacts'),
			2	=> new WBXMLCodePage(2,[],'Email:','email'),
			//No codepage with number 3
			4	=> new WBXMLCodePage(4,[],'Calendar:','calendar'),
			5	=> new WBXMLCodePage(5,[],'Move:','move'),
			6	=> new WBXMLCodePage(6,[],'GetItemEstimate:','getitemestimate'),
			7	=> new WBXMLCodePage(7,[],'FolderHierarchy:','folderhierarchy'),
			8	=> new WBXMLCodePage(8,[],'MeetingResponse:','meetingresponse'),
			9	=> new WBXMLCodePage(9,[],'Tasks:','tasks'),
			10	=> new WBXMLCodePage(10,[],'ResolveRecipients:','resolverecipients'),
			11	=> new WBXMLCodePage(11,[],'ValidateCert:','validatecert'),
			12	=> new WBXMLCodePage(12,[],'Contacts2:','contacts2'),
			13	=> new WBXMLCodePage(13,[],'Ping:','ping'),
			14	=> new WBXMLCodePage(14,[],'Provision:','provision'),
			15	=> new WBXMLCodePage(15,[],'Search:','search'),
			16	=> new WBXMLCodePage(16,[],'GAL:','gal'),
			17	=> new WBXMLCodePage(17,[],'AirSyncBase:','airsyncbase'),
			18	=> new WBXMLCodePage(18,[],'Settings:','settings'),
			19	=> new WBXMLCodePage(19,[],'DocumentLibrary:','documentlibrary'),
			20	=> new WBXMLCodePage(20,[],'ItemOperations:','itemoperations'),
			21	=> new WBXMLCodePage(21,[],'ComposeMail:','composemail'),
			22	=> new WBXMLCodePage(22,[],'Email2:','email2'),
			23	=> new WBXMLCodePage(23,[],'Notes:','notes'),
			24	=> new WBXMLCodePage(24,[],'RightsManagement:','rightsmanagement'),
			25	=> new WBXMLCodePage(25,[],'Find:','find'),
		];
	}

}