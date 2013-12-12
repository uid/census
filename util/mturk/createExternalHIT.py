from boto.mturk.connection import MTurkConnection
from boto.mturk.question import ExternalQuestion
from awskeys import AWS_ACCESS_KEY, AWS_SECRET_KEY

SANDBOX = True

NUMBER_OF_HITS = 3
NUMBER_OF_ASSIGNMENTS = 50
LIFETIME = 60 * 60 * 24
REWARD = 0.04
TITLE = 'Five question survey about the web and your community'
EXPLANATION = 'We are investigating how much the web and your community interact. This is a five-question survey, all agree/disagree questions.'

def create_hits():
	if SANDBOX:
		mturk_url = 'mechanicalturk.sandbox.amazonaws.com'
		preview_url = 'https://workersandbox.mturk.com/mturk/preview?groupId='
	else:
		mturk_url = 'mechanicalturk.amazonaws.com'
		preview_url = 'https://mturk.com/mturk/preview?groupId='

	q = ExternalQuestion(external_url="https://census.stanford.edu/client/demo/maintask.html", frame_height=800)
	conn = MTurkConnection(aws_access_key_id=AWS_ACCESS_KEY, aws_secret_access_key=AWS_SECRET_KEY, host=mturk_url)
	keywords=['census']
	for i in range(0, NUMBER_OF_HITS):
		create_hit_rs = conn.create_hit(question=q, lifetime=LIFETIME,max_assignments=NUMBER_OF_ASSIGNMENTS,title=TITLE, keywords=keywords,reward = REWARD, duration=60*6,approval_delay=60*60, annotation=EXPLANATION)
		print(preview_url + create_hit_rs[0].HITTypeId)
    
if __name__ == "__main__":
	create_hits()
  
