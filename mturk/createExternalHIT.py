from boto.mturk.connection import MTurkConnection
from boto.mturk.question import ExternalQuestion
from awskeys import AWS_ACCESS_KEY, AWS_SECRET_KEY


SANDBOX = True

NUMBER_OF_HITS = 1
NUMBER_OF_ASSIGNMENTS = 3
LIFETIME = 60 * 24 * 2
TITLE = 'Identify emotions provoked'
EXPLANATION = 'Score the news headline for how much it provokes specific emotions'

def create_hits():
	if SANDBOX:
		mturk_url = 'mechanicalturk.sandbox.amazonaws.com'
		preview_url = 'https://workersandbox.mturk.com/mturk/preview?groupId='
	else:
		mturk_url = 'mechanicalturk.amazonaws.com'
		preview_url = 'https://mturk.com/mturk/preview?groupId='

	q = ExternalQuestion(external_url="https://census.stanford.edu/client/demo.html", frame_height=800)
	conn = MTurkConnection(aws_access_key_id=AWS_ACCESS_KEY, aws_secret_access_key=AWS_SECRET_KEY, host=mturk_url)
	keywords=['census']
	for i in range(0, NUMBER_OF_HITS):
		create_hit_rs = conn.create_hit(question=q, lifetime=LIFETIME,max_assignments=NUMBER_OF_ASSIGNMENTS,title=TITLE, keywords=keywords,reward = 0.05, duration=60*6,approval_delay=60*60, annotation=EXPLANATION)
		print(preview_url + create_hit_rs[0].HITId)
    
if __name__ == "__main__":
	create_hits()
  
